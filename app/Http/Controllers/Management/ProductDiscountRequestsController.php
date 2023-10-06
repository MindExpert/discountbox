<?php

namespace App\Http\Controllers\Management;

use App\Enums\DiscountRequestStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\DiscountRequest;
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

class ProductDiscountRequestsController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $this->authorize('viewAny', DiscountRequest::class);

        if ($request->ajax() || $request->wantsJson()) {
            try {

                $datatableQuery = DiscountRequest::query()
                    ->select(['discount_requests.*'])
                    ->with(['user', 'discount_box', 'product']);

                return DataTables::eloquent($datatableQuery)
                    ->addColumn('permissions', function (DiscountRequest $productDiscountRequest) {
                        $view     = user()->can('view', $productDiscountRequest);
                        $delete   = user()->can('delete', $productDiscountRequest);
                        $toggleStatus = user()->can('toggleStatus', $productDiscountRequest);

                        return [
                            'view'    => $view,
                            'delete'    => $delete,
                            'toggleStatus' => $toggleStatus,
                        ];
                    })
                    ->editColumn('created_at', function (DiscountRequest $productDiscountRequest) {
                        return $productDiscountRequest->created_at->format('d/m/Y H:i:s');
                    })
                    ->editColumn('approved_at', function (DiscountRequest $productDiscountRequest) {
                        return $productDiscountRequest->approved_at
                            ? $productDiscountRequest->approved_at->format('d/m/Y H:i:s')
                            : "---";
                    })
                    ->editColumn('user_id', function (DiscountRequest $productDiscountRequest) {
                        return view('management.product-discount-requests.datatable.user', compact('productDiscountRequest'));
                    })
                    ->editColumn('discount_box_id', function (DiscountRequest $productDiscountRequest) {
                        return view('management.product-discount-requests.datatable.discount_box', compact('productDiscountRequest'));
                    })
                    ->editColumn('product_id', function (DiscountRequest $productDiscountRequest) {
                        return view('management.product-discount-requests.datatable.product', compact('productDiscountRequest'));
                    })
                    ->editColumn('status', function (DiscountRequest $productDiscountRequest) {
                        if (! empty($productDiscountRequest->notes)) {
                            $html = nl2br($productDiscountRequest->notes);
                        } else {
                            $html = __('general.no_data');
                        }

                        return view('management.product-discount-requests.datatable.status', compact('productDiscountRequest', 'html'));
                    })
                    ->addColumn('actions', 'management.product-discount-requests.datatable.actions')
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
                    ->filterColumn('product_id', function (Builder $query, $keyword) {
                        if ($keyword) {
                            if (is_numeric($keyword)) {
                                return $query->where('discount_requests.product_id', $keyword);
                            } else {
                                return $query->whereIn('discount_requests.product_id', function ($subQuery) use ($keyword) {
                                    return $subQuery->select('id')
                                        ->from('discount_boxes')
                                        ->whereRaw("CONVERT(products.serial using 'utf8mb4') like ?", ["%$keyword%"])
                                        ->orWhereRaw("CONVERT(products.name using 'utf8mb4') like ?", ["%$keyword%"]);
                                });
                            }
                        }
                        return $query;
                    })
                    ->rawColumns(['actions', 'user_id', 'discount_box_id', 'product_id', 'status'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return EmptyDatatable::toJson();
            }
        }

        return view('management.product-discount-requests.index');
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

    public function show(DiscountRequest $productDiscountRequest): View
    {
        $this->authorize('view', $productDiscountRequest);

        return view('management.product-discount-requests.show', compact('productDiscountRequest'));
    }

    public function approve(Request $request, DiscountRequest $productDiscountRequest): RedirectResponse
    {
        $this->authorize('toggleStatus', $productDiscountRequest);

        try {
            DB::beginTransaction();

            // Check user balance, if user balance is less than credit, throw exception
            // We re-add the credit to the user's balance to check the balance against the credit of the request
            $userBalance = $productDiscountRequest->user->availableBalance() + $productDiscountRequest->credit;

            if ($userBalance < $productDiscountRequest->credit) {
                throw new Exception(__('discount_request.responses.not_approved'));
            }

            $productDiscountRequest->user->transactions()->create([
                'user_id' => $request->input('user_id'),
                'credit'  => 0,
                'debit'   => $productDiscountRequest->credit,
                'type'    => TransactionTypeEnum::EXPENDITURE,
                'name'    => json_encode([
                    'lang'   => 'transaction.event.expenditure',
                    'params' => []
                ]),
                'notes' => json_encode([
                    'lang'   => 'transaction.names.expenditure_for_request',
                    'params' => [
                        'product' => $productDiscountRequest->product->name,
                    ]
                ]),
                'transactional_type' => DiscountRequest::$morph_key,
                'transactional_id'   => $productDiscountRequest->id,
            ]);

            $productDiscountRequest->update([
                'status'      => DiscountRequestStatusEnum::APPROVED,
                'approved_at' => now(),
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
            return redirect()->route('management.product-discount-requests.index');
        }
    }

    public function reject(Request $request, DiscountRequest $productDiscountRequest): RedirectResponse
    {
        $this->authorize('toggleStatus', $productDiscountRequest);

        try {

            $productDiscountRequest->update([
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
            return redirect()->route('management.product-discount-requests.index');
        }
    }

    public function destroy(Request $request, DiscountRequest $productDiscountRequest): RedirectResponse
    {
        $this->authorize('delete', $productDiscountRequest);

        try {
            $productDiscountRequest->delete();

            FlashNotification::success(__('general.success'), __('discount_request.responses.deleted'));
        } catch (Exception $exception) {
            report($exception);
            FlashNotification::error(__('general.error'), __('discount_request.responses.not_deleted'));
        }

        if ($request->get('redirect_to')) {
            return redirect()->to($request->get('redirect_to'));
        } else {
            return redirect()->route('management.product-discount-requests.index');
        }

    }
}
