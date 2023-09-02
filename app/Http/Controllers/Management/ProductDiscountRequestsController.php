<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\ProductDiscountRequest;
use App\Support\EmptyDatatable;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductDiscountRequestsController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $this->authorize('viewAny', ProductDiscountRequest::class);

        if ($request->ajax() || $request->wantsJson()) {
            try {

                $datatableQuery = ProductDiscountRequest::query()
                    ->select(['product_discount_requests.*'])
                    ->with(['user', 'discount_box', 'product']);

                return DataTables::eloquent($datatableQuery)
                    ->addColumn('permissions', function (ProductDiscountRequest $productDiscountRequest) {
                        $view    = user()->can('view', $productDiscountRequest);
                        $approve = user()->can('update', $productDiscountRequest);
                        $reject  = user()->can('delete', $productDiscountRequest);

                        return [
                            'view'    => $view,
                            'approve' => $approve,
                            'reject'  => $reject,
                        ];
                    })
                    ->editColumn('created_at', function (ProductDiscountRequest $productDiscountRequest) {
                        return $productDiscountRequest->created_at->format('d/m/Y H:i:s');
                    })
                    ->editColumn('approved_at', function (ProductDiscountRequest $productDiscountRequest) {
                        return $productDiscountRequest->approved_at
                            ? $productDiscountRequest->approved_at->format('d/m/Y H:i:s')
                            : "---";
                    })
                    ->editColumn('user_id', function (ProductDiscountRequest $productDiscountRequest) {
                        return view('management.product-discount-requests.datatable.user', compact('productDiscountRequest'));
                    })
                    ->editColumn('discount_box_id', function (ProductDiscountRequest $productDiscountRequest) {
                        return view('management.product-discount-requests.datatable.discount_box', compact('productDiscountRequest'));
                    })
                    ->editColumn('product_id', function (ProductDiscountRequest $productDiscountRequest) {
                        return view('management.product-discount-requests.datatable.product', compact('productDiscountRequest'));
                    })
                    ->editColumn('status', function (ProductDiscountRequest $productDiscountRequest) {
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
                                return $query->where('product_discount_requests.user_id', $keyword);
                            } else {
                                return $query->whereIn('product_discount_requests.user_id', function ($subQuery) use ($keyword) {
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
                                return $query->where('product_discount_requests.discount_box_id', $keyword);
                            } else {
                                return $query->whereIn('product_discount_requests.discount_box_id', function ($subQuery) use ($keyword) {
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
                                return $query->where('product_discount_requests.product_id', $keyword);
                            } else {
                                return $query->whereIn('product_discount_requests.product_id', function ($subQuery) use ($keyword) {
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
        $this->authorize('search', ProductDiscountRequest::class);

        return response()->json(
            ProductDiscountRequest::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()->append(['label'])
        );
    }

    public function show(ProductDiscountRequest $productDiscountRequest): View
    {
        $this->authorize('view', $productDiscountRequest);

        return view('management.product-discount-requests.show', compact('productDiscountRequest'));
    }
}
