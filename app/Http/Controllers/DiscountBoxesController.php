<?php

namespace App\Http\Controllers;

use App\Enums\DiscountRequestStatusEnum;
use App\Enums\StatusEnum;
use App\Models\DiscountBox;
use App\Models\Product;
use App\Models\DiscountRequest;
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
        //$this->middleware('auth');
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
            ->where('discount_boxes.show_on_home', 'true')
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
        $statuses = StatusEnum::IN_PROGRESS->value;

        if ($status === StatusEnum::AWARDED || $status === StatusEnum::CONCLUDED) {
            $statuses = [StatusEnum::AWARDED->value, StatusEnum::CONCLUDED->value];
        }

        $discountBoxes = DiscountBox::query()
            ->with(['media', 'product'])
            ->where('discount_boxes.status', $statuses)
            ->where('discount_boxes.show_on_home', 'true')
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
        $discountBox->load('media', 'product', 'coupon');

        $userAvailableCredit = auth()->user()?->availableBalance();

        //return view('frontend.discount-boxes.show', compact('discountBox'));
        return view('frontend.discount-boxes.show', compact('discountBox', 'userAvailableCredit'));
    }

    /**
     * Display the specified product of the discountbox.
     * @param Request $request
     * @param DiscountBox $discountBox
     * @return JsonResponse
     */
    public function submitRequestDiscount(Request $request, DiscountBox $discountBox): JsonResponse
    {
        $userAvailableCredit = user()->availableBalance();

        if ($userAvailableCredit < $discountBox->credits) {
            return response()->json([
                'success' => false,
                'message' => __('Non hai abbastanza credito per richiedere questo sconto.'),
            ], 422);
        }

        $requestExists = DiscountRequest::query()
            ->where('user_id', user()->id)
            ->where('discount_box_id', $discountBox->id)
            //->where('status', DiscountRequestStatusEnum::PENDING)
            ->exists();

        if ($requestExists) {
            return response()->json([
                'success' => false,
                'message' => __('Hai già richiesto un\'iscrizione per questo sconto.'),
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

        return response()->json([
            'success' => true,
            'message' => __('La tua richiesta è stata inviata con successo.'),
            'data'    => $discountRequest,
        ], 200);
    }
}
