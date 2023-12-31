<?php

namespace App\Http\Controllers\Management;

use App\Enums\DiscountRequestStatusEnum;
use App\Enums\StatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\DiscountRequestStoreRequest;
use App\Models\DiscountBox;
use App\Models\DiscountRequest;
use App\Models\Transaction;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DiscountRequestsController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $this->authorize('viewAny', DiscountRequest::class);

        if ($request->ajax() || $request->wantsJson()) {
            try {

                $datatableQuery = DiscountRequest::query()
                    ->select(['discount_requests.*'])
                    ->with(['user', 'discount_box']);

                return DataTables::eloquent($datatableQuery)
                    ->addColumn('permissions', function (DiscountRequest $discountRequest) {
                        $view     = user()->can('view', $discountRequest);
                        $delete   = user()->can('delete', $discountRequest);
                        $toggleStatus = user()->can('toggleStatus', $discountRequest);

                        return [
                            'view'    => $view,
                            'delete'    => $delete,
                            'toggleStatus' => $toggleStatus,
                        ];
                    })
                    ->editColumn('percentage', function (DiscountRequest $discountRequest) {
                        return "{$discountRequest->percentage} %";
                    })
                    ->editColumn('created_at', function (DiscountRequest $discountRequest) {
                        return $discountRequest->created_at->format('d/m/Y H:i:s');
                    })
                    ->editColumn('approved_at', function (DiscountRequest $discountRequest) {
                        return $discountRequest->approved_at
                            ? $discountRequest->approved_at->format('d/m/Y H:i:s')
                            : "---";
                    })
                    ->editColumn('user_id', function (DiscountRequest $discountRequest) {
                        return view('management.discount-requests.datatable.user', compact('discountRequest'));
                    })
                    ->editColumn('discount_box_id', function (DiscountRequest $discountRequest) {
                        return view('management.discount-requests.datatable.discount_box', compact('discountRequest'));
                    })
                    ->editColumn('status', function (DiscountRequest $discountRequest) {
                        if (! empty($discountRequest->notes)) {
                            $html = nl2br($discountRequest->notes);
                        } else {
                            $html = __('general.no_data');
                        }

                        return view('management.discount-requests.datatable.status', compact('discountRequest', 'html'));
                    })
                    ->addColumn('actions', 'management.discount-requests.datatable.actions')
                    ->filterColumn('user_id', function (Builder $query, $keyword) {
                        if ($keyword) {
                            if (is_numeric($keyword)) {
                                return $query->where('discount_requests.user_id', $keyword);
                            } else {
                                return $query->whereIn('discount_requests.user_id', function ($subQuery) use ($keyword) {
                                    return $subQuery->select('id')
                                        ->from('users')
                                        ->whereRaw("CONVERT(users.first_name using 'utf8mb4') like ?", ["%$keyword%"])
                                        ->orWhereRaw("CONVERT(users.last_name using 'utf8mb4') like ?", ["%$keyword%"]);
                                });
                            }
                        }
                        return $query;
                    })
                    ->filterColumn('discount_box_id', function (Builder $query, $keyword) {
                        if ($keyword) {
                            if (is_numeric($keyword)) {
                                return $query->where('discount_requests.discount_box_id', $keyword);
                            } else {
                                return $query->whereIn('discount_requests.discount_box_id', function ($subQuery) use ($keyword) {
                                    return $subQuery->select('id')
                                        ->from('discount_boxes')
                                        ->whereRaw("CONVERT(discount_boxes.serial using 'utf8mb4') like ?", ["%$keyword%"])
                                        ->orWhereRaw("CONVERT(discount_boxes.name using 'utf8mb4') like ?", ["%$keyword%"]);
                                });
                            }
                        }
                        return $query;
                    })
                    ->rawColumns(['actions', 'user_id', 'discount_box_id', 'status'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return EmptyDatatable::toJson();
            }
        }

        return view('management.discount-requests.index');
    }

    public function search(Request $request): JsonResponse
    {
        $this->authorize('search', DiscountRequest::class);

        return response()->json(
            DiscountRequest::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()->append(['label'])
        );
    }

    public function create(): View
    {
        $this->authorize('create', DiscountRequest::class);

        return view('management.discount-requests.create');
    }

    public function store(DiscountRequestStoreRequest $request)
    {
        $this->authorize('create', DiscountRequest::class);

        try {
            DB::beginTransaction();

            /** @var DiscountBox $discountBox */
            $discountBox = DiscountBox::query()->findOrFail($request->get('discount_box_id'));

            /** @var DiscountRequest $discountRequest */
            $discountRequest = DiscountRequest::query()
                ->create([
                    'user_id'         => $request->get('user_id'),
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

            DB::commit();
            FlashNotification::success(__('general.success'), __('discount_request.responses.created'));
            return ActionJsonResponse::make(true, route('management.discount-requests.show', ['discountRequest' => $discountRequest->id]))->response();
        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();

            FlashNotification::error(__('general.error'), __('discount_request.responses.not_created'));
            return ActionJsonResponse::make(false, route('management.discount-requests.index'))->response();
        }
    }

    public function show(DiscountRequest $discountRequest): View
    {
        $this->authorize('view', $discountRequest);

        return view('management.discount-requests.show', compact('discountRequest'));
    }

    public function approve(Request $request, DiscountRequest $discountRequest): RedirectResponse
    {
        $this->authorize('toggleStatus', $discountRequest);

        try {
            DB::beginTransaction();

            $discountRequest->discount_box->update([
                'status' => StatusEnum::AWARDED,
            ]);

            $discountRequest->update([
                'status'      => DiscountRequestStatusEnum::APPROVED,
                'approved_at' => now(),
            ]);

            // Make all other transactions as rejected
            DiscountRequest::query()
                ->where('discount_box_id', $discountRequest->discount_box_id)
                ->where('id', '!=', $discountRequest->id)
                ->update([
                    'status' => DiscountRequestStatusEnum::REJECTED,
                ]);

            DB::commit();
            FlashNotification::success(__('general.success'), __('discount_request.responses.approved'));
        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();

            FlashNotification::error(__('general.error'), __('discount_request.responses.not_approved'));
        }

        if ($request->get('redirect_to')) {
            return redirect()->to($request->get('redirect_to'));
        } else {
            return redirect()->route('management.discount-requests.index');
        }
    }

    public function reject(Request $request, DiscountRequest $discountRequest): RedirectResponse
    {
        $this->authorize('toggleStatus', $discountRequest);

        try {

            $discountRequest->update([
                'status'      => DiscountRequestStatusEnum::REJECTED,
                'approved_at' => null,
            ]);

            FlashNotification::success(__('general.success'), __('discount_request.responses.rejected'));
        } catch (Exception $exception) {
            report($exception);
            FlashNotification::error(__('general.error'), __('discount_request.responses.not_rejected'));
        }

        if ($request->get('redirect_to')) {
            return redirect()->to($request->get('redirect_to'));
        } else {
            return redirect()->route('management.discount-requests.index');
        }
    }

    public function destroy(Request $request, DiscountRequest $discountRequest): RedirectResponse
    {
        $this->authorize('delete', $discountRequest);

        try {
            $discountRequest->delete();

            FlashNotification::success(__('general.success'), __('discount_request.responses.deleted'));
        } catch (Exception $exception) {
            report($exception);
            FlashNotification::error(__('general.error'), __('discount_request.responses.not_deleted'));
        }

        if ($request->get('redirect_to')) {
            return redirect()->to($request->get('redirect_to'));
        } else {
            return redirect()->route('management.discount-requests.index');
        }

    }
}
