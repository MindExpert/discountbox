<?php

namespace App\Http\Controllers;

use App\Enums\DiscountRequestStatusEnum;
use App\Enums\StatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\DiscountBox;
use App\Models\Product;
use App\Models\DiscountRequest;
use App\Models\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountBoxesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only([
            'submitRequestDiscount',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $discountBoxes = DiscountBox::query()
            ->addSelect(['participants' => DiscountRequest::query()
                ->selectRaw('count(*)')
                ->whereColumn('discount_requests.discount_box_id', 'discount_boxes.id')
            ])
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('discount_boxes.status', $request->input('status'));
            })
            ->with(['media'])
            ->where('discount_boxes.show_on_home', true)
            ->orderBy('discount_boxes.created_at', 'DESC')
            ->paginate(12, ['*'], 'discount_boxes_page')
            ->withQueryString();

        return view('frontend.discount-boxes.index', compact('discountBoxes'));
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function indexByStatus(Request $request, StatusEnum $status)
    {
        $statuses = [StatusEnum::IN_PROGRESS->value];

        if ($status === StatusEnum::AWARDED || $status === StatusEnum::CONCLUDED) {
            $statuses = [StatusEnum::AWARDED->value, StatusEnum::CONCLUDED->value];
        }

        $discountBoxes = DiscountBox::query()
            ->with(['media', 'product'])
            ->whereIn('discount_boxes.status', $statuses)
            ->addSelect(['participants' => DiscountRequest::query()
                ->selectRaw('count(*)')
                ->whereColumn('discount_requests.discount_box_id', 'discount_boxes.id')
            ])
            ->orderBy('discount_boxes.created_at', 'DESC')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.discount-boxes.index-by-status', compact('discountBoxes'));
    }

    /**
     * Display the specified product inside the discountbox.
     * @param DiscountBox $discountBox
     * @return View
     */
    public function show(DiscountBox $discountBox)
    {
        $discountBox->load('media', 'product', 'coupon')
            ->loadCount('discount_requests as participants');

        $winnerUser = $discountBox->discount_requests()
            ->with('user')
            ->where('status', DiscountRequestStatusEnum::APPROVED)
            ->first() ?? null;

        $userAvailableCredit = auth()->user()?->availableBalance();

        return view('frontend.discount-boxes.show', compact('discountBox', 'userAvailableCredit', 'winnerUser'));
    }

    /**
     * Display the specified product of the discountbox.
     * @param Request $request
     * @param DiscountBox $discountBox
     * @return JsonResponse
     */
    public function submitRequestDiscount(Request $request, DiscountBox $discountBox): JsonResponse
    {
        $requestExists = DiscountRequest::query()
            ->where('user_id', user()->id)
            ->where('discount_box_id', $discountBox->id)
            ->exists();

        if ($requestExists) {
            return response()->json([
                'success' => false,
                'message' => __('discount_request.messages.already_requested'),
            ], 422);
        }

        $userAvailableCredit = user()->availableBalance();

        if ($userAvailableCredit < $discountBox->credits) {
            return response()->json([
                'success' => false,
                'message' => __('discount_request.messages.not_enough_credits'),
            ], 422);
        }

        if ($discountBox->status !== StatusEnum::IN_PROGRESS) {
            return response()->json([
                'success' => false,
                'message' => __('discount_request.messages.discount_box_not_in_progress'),
            ], 422);
        }

        if ($request->input('percentage') > 100 || $request->input('percentage') < 0) {
            return response()->json([
                'success' => false,
                'message' => __('discount_request.messages.invalid_percentage'),
            ], 422);
        }

        /** @var DiscountRequest $discountRequest */
        $discountRequest = DiscountRequest::query()
            ->create([
                'user_id'         => user()->id,
                'discount_box_id' => $discountBox->id,
                'credit'          => $discountBox->credits,
                'percentage'      => $request->input('percentage'),
                'status'          => DiscountRequestStatusEnum::PENDING,
            ]);

        Transaction::create([
            'user_id' => $discountRequest->user_id,
            'credit'  => 0,
            'debit'   => $discountRequest->credit,
            'type'    => TransactionTypeEnum::EXPENDITURE,
            'name'    => json_encode([
                'lang'   => 'transaction.event.expenditure',
                'params' => []
            ]),
            'notes' => json_encode([
                'lang'   => 'transaction.names.expenditure_for_request',
                'params' => [
                    'product' => $discountRequest->discount_box->name,
                ]
            ]),
            'transactional_type' => DiscountRequest::$morph_key,
            'transactional_id'   => $discountRequest->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => __('discount_request.messages.request_sent'),
            'data'    => $discountRequest,
        ], 200);
    }
}
