<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Management\CouponStoreRequest;
use App\Models\Coupon;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CouponsController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $this->authorize('viewAny', Coupon::class);

        if ($request->ajax() || $request->wantsJson()) {
            try {

                $datatableQuery = Coupon::query()->select(['coupons.*']);

                return DataTables::eloquent($datatableQuery)
                    ->addColumn('permissions', function (Coupon $coupon) {
                        $view   = user()->can('view', $coupon);
                        $delete = user()->can('delete', $coupon);

                        return [
                            'view'   => $view,
                            'delete' => $delete,
                        ];
                    })
                    ->editColumn('user_id', fn(Coupon $coupon) => view('management.coupons.datatable.user', compact('coupon')))
                    ->editColumn('assignee_id', fn(Coupon $coupon) => view('management.coupons.datatable.assignee', compact('coupon')))
                    ->editColumn('type', fn(Coupon $coupon) => view('management.coupons.datatable.type', compact('coupon')))
                    ->editColumn('valid_from', function (Coupon $coupon) {
                        return $coupon->valid_from?->format('d/m/Y');
                    })
                    ->editColumn('expires_at', function (Coupon $coupon) {
                        return $coupon->expires_at?->format('d/m/Y');
                    })
                    ->editColumn('applied_at', function (Coupon $coupon) {
                        return $coupon->applied_at?->format('d/m/Y');
                    })
                    ->addColumn('actions', 'management.coupons.datatable.actions')
                    ->rawColumns(['actions','user_id', 'assignee_id', 'type'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return EmptyDatatable::toJson();
            }
        }

        return view('management.coupons.index');
    }

    public function search(Request $request): JsonResponse
    {
        $this->authorize('search', Coupon::class);

        return response()->json(
            Coupon::search(
                $request->get('keyword'),
                $request->get('id'),
                $request->get('only_active'),
            )->get()->append(['label'])
        );
    }

    public function create(): View
    {
        $this->authorize('create', Coupon::class);

        return view('management.coupons.create');
    }

    public function store(CouponStoreRequest $request): JsonResponse
    {
        $this->authorize('create', Coupon::class);

        try {
            /** @var Coupon $coupon */
            $coupon = Coupon::query()->create([
                'user_id'     => auth()->user()->id,
                'assignee_id' => $request->input('assignee_id') ?? null,
                'code'        => $request->input('code') ?? null,
                'type'        => $request->input('type'),
                'discount'    => $request->input('discount'),
                'valid_from'  => $request->input('valid_from'),
                'expires_at'  => $request->input('expires_at'),
            ]);

            FlashNotification::success(__('general.success'), __('coupon.responses.created'));
            return ActionJsonResponse::make(true, route('management.coupons.show', ['coupon' => $coupon->id]))->response();
        } catch (Exception $exception) {
            report($exception);

            FlashNotification::error(__('general.error'), __('coupon.responses.not_created'));
            return ActionJsonResponse::make(false, route('management.coupons.index'))->response();
        }
    }

    public function show(Coupon $coupon): View
    {
        $this->authorize('view', $coupon);

        return view('management.coupons.show', compact('coupon'));
    }

//    public function edit(Coupon $coupon): View
//    {
//        $this->authorize('update', $user);
//
//        return view('management.users.edit', compact('user'));
//    }
//
//    public function update(CouponUpdateRequest $request, Coupon $coupon): JsonResponse
//    {
//        $this->authorize('update', $coupon);
//
//        try {
//            $coupon->update([
//                'role'            => $request->input('role'),
//                'first_name'      => $request->input('first_name'),
//                'last_name'       => $request->input('last_name'),
//                'nickname'        => $request->input('nickname'),
//                'email'           => $request->input('email'),
//                'mobile'          => $request->input('mobile'),
//                //'locale'          => $request->input('locale'),
//                'birth_date'      => $request->input('birth_date'),
//            ]);
//
//            $user->touch();
//
//            FlashNotification::success(__('general.success'), __('user.responses.updated'));
//            return ActionJsonResponse::make(true, route('management.users.show', ['user' => $user->id]))->response();
//        } catch (Exception $exception) {
//            report($exception);
//
//            FlashNotification::error(__('general.error'), __('user.responses.not_updated'));
//            return ActionJsonResponse::make(false, route('management.users.index'))->response();
//        }
//
//    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $this->authorize('delete', $coupon);

        try {
            $coupon->delete();

            FlashNotification::success(__('general.success'), __('user.responses.deleted'));
        } catch (Exception $exception) {
            report($exception);
            FlashNotification::error(__('general.error'), __('user.responses.not_deleted'));
        }

        return redirect()->route('management.coupons.index');
    }
}
