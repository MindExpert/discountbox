<?php

namespace App\Http\Controllers\Management;

use App\Enums\DiscountRequestStatusEnum;
use App\Enums\DiscountTypeEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\DiscountBoxStoreRequest;
use App\Http\Requests\Management\DiscountBoxUpdateRequest;
use App\Models\Coupon;
use App\Models\DiscountBox;
use App\Models\DiscountRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DiscountBoxesController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $this->authorize('viewAny', DiscountBox::class);

        if ($request->ajax() || $request->wantsJson()) {
            try {

                $datatableQuery = DiscountBox::query()
                    ->with(['coupon', 'media'])
                    ->select(['discount_boxes.*'])
                    ->withCount('discount_requests');

                return DataTables::eloquent($datatableQuery)
                    ->addColumn('permissions', function (DiscountBox $discountBox) {
                        $view   = user()->can('view', $discountBox);
                        $update = user()->can('update', $discountBox);
                        $delete = user()->can('delete', $discountBox);

                        return [
                            'view'   => $view,
                            'update' => $update,
                            'delete' => $delete,
                        ];
                    })
                    ->addColumn('image', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.image', compact('discountBox'))->render())
                    ->editColumn('name', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.name', compact('discountBox'))->render())
                    ->editColumn('status', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.status', compact('discountBox'))->render())
                    ->editColumn('highlighted', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.highlighted', compact('discountBox'))->render())
                    ->editColumn('show_on_home', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.show_on_home', compact('discountBox'))->render())
                    ->editColumn('coupon_id', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.coupon', compact('discountBox'))->render())
                    ->filterColumn('coupon_id', function (Builder $query, $keyword) {
                        if ($keyword) {
                            if (is_numeric($keyword)) {
                                return $query->where('discount_boxes.coupon_id', $keyword);
                            } else {
                                return $query->whereIn('discount_boxes.coupon_id', function ($subQuery) use ($keyword) {
                                    return $subQuery->select('id')
                                        ->from('coupons')
                                        ->whereRaw("CONVERT(coupons.code using 'utf8mb4') like ?", ["%$keyword%"]);
                                });
                            }
                        }
                        return $query;
                    })
                    ->addColumn('actions', 'management.discount-boxes.datatable.actions')
                    ->rawColumns(['actions', 'image', 'name', 'status', 'highlighted', 'show_on_home', 'coupon_id'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return EmptyDatatable::toJson();
            }
        }

        return view('management.discount-boxes.index');
    }

    public function search(Request $request): JsonResponse
    {
        $this->authorize('search', DiscountBox::class);

        return response()->json(
            DiscountBox::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()->append(['label'])
        );
    }

    /**
     * Used to populate dynamically the modal with data
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function image(Request $request): JsonResponse
    {
        /** @var DiscountBox $discountBox */
        $discountBox = DiscountBox::query()
            ->with('media')
            ->where('id', $request->input('model_id'))
            ->firstOrFail();

        $this->authorize('view', $discountBox);

        $redirectTo = $request->get('redirect_to');

        $modalDetails = view('management.discount-boxes._partials.cover-image-modal', compact('discountBox', 'redirectTo'))->render();

        return response()->json([
            'data' => [
                'model_id' => $discountBox->id,
                'details'  => $modalDetails,
            ],
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', DiscountBox::class);

        return view('management.discount-boxes.create');
    }

    public function store(DiscountBoxStoreRequest $request): JsonResponse
    {
        $this->authorize('create', DiscountBox::class);

        try {
            DB::beginTransaction();

            /** @var Coupon $coupon */
            $coupon = Coupon::query()
                ->where('id', $request->input('coupon_id'))
                ->first();

            // if ($coupon === null || ! $coupon->isValid() || $coupon->hasExpired()) {
            //     FlashNotification::error(__('general.error'), __('discount_box.responses.coupon_invalid'));
            //     throw new Exception(__('discount_box.responses.coupon_invalid'));
            // }

            $price = $request->input('price');
            $discount = 0;

            // if ($coupon->type === DiscountTypeEnum::VALUE) {
            //     $discount = $coupon->discount;
            // } else {
            //     $discount = ($coupon->discount * $price) / 100;
            // }

            $total = (($price >= $discount) ? ($price - $discount) : 0);

            /** @var DiscountBox $discountBox */
            $discountBox = DiscountBox::query()->create([
                'user_id'       => user()->id,
                'coupon_id'     => $coupon?->id,
                'name'          => $request->input('name'),
                //'status'      => $request->input('status') ?? StatusEnum::IN_PROGRESS->value, #IS AUTO CALC FROM STATUS
                'status'        => StatusEnum::IN_PROGRESS->value,
                'credits'       => $request->input('credits'),
                'price'         => $price,
                'discount'      => $discount, #TODO: To be calculate based on the coupon, if is present
                'total'         => $total,
                'expires_at'    => $request->input('expires_at'),
                'highlighted'   => $request->boolean('highlighted'),
                'show_on_home'  => $request->boolean('show_on_home'),
                'product_id'    => $request->input('product_id'),
                'max_discount_percentage' => $request->input('max_discount_percentage') ?? '0',
            ]);

            # ADD Images to Media Library when creating
            if ($request->input('cover_image') !== null) {
                $discountBox->addFromMediaLibraryRequest($request->input('cover_image'))
                    ->toMediaCollection('cover_image');
            }

            DB::commit();

            FlashNotification::success(__('general.success'), __('discount_box.responses.created'));
            return ActionJsonResponse::make(true, route('management.discount-boxes.show', ['discountBox' => $discountBox->id]))->response();
        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();

            FlashNotification::error(__('general.error'), __('discount_box.responses.not_created'));
            return ActionJsonResponse::make(false, route('management.discount-boxes.index'))->response();
        }
    }

    public function show(DiscountBox $discountBox): View
    {
        $this->authorize('view', $discountBox);

        return view('management.discount-boxes.show', compact('discountBox'));
    }

    public function edit(DiscountBox $discountBox): View
    {
        $this->authorize('update', $discountBox);

        $discountBox->load(['media', 'coupon', 'product']);

        $discountRequestsUser = DiscountRequest::query()
            ->where('discount_box_id', $discountBox->id)
            ->selectRaw("
                users.id as user_id,
                users.nickname as nickname,
                discount_requests.percentage as percentage
            ")
            ->join('users', 'users.id', '=', 'discount_requests.user_id')
            ->orderByRaw('discount_requests.percentage ASC')
            ->get();

        return view('management.discount-boxes.edit', compact('discountBox', 'discountRequestsUser'));
    }

    public function update(DiscountBoxUpdateRequest $request, DiscountBox $discountBox): JsonResponse
    {
        $this->authorize('update', $discountBox);

        try {
            DB::beginTransaction();

            /** @var Coupon $coupon */
            $coupon = Coupon::query()
                ->where('id', $request->input('coupon_id'))
                ->first();
            // if ($coupon === null || ! $coupon->isValid() || $coupon->hasExpired()) {
            //     FlashNotification::error(__('general.error'), __('discount_box.responses.coupon_invalid'));
            //     throw new Exception(__('discount_box.responses.coupon_invalid'));
            // }

            $price    = $request->input('price');
            $discount = 0;

            // if ($coupon->type === DiscountTypeEnum::VALUE) {
            //     $discount = $coupon->discount;
            // } else {
            //     $discount = ($coupon->discount * $price) / 100;
            // }

            $total = (($price >= $discount) ? ($price - $discount) : 0);

            $discountBox->update([
                'coupon_id'     => $coupon?->id,
                'name'          => $request->input('name'),
                'status'        => $request->input('status'),
                'credits'       => $request->input('credits'),
                'price'         => $price,
                'discount'      => $discount, #TODO: To be calculate based on the coupon, if is present
                'total'         => $total,
                'expires_at'    => $request->input('expires_at'),
                'highlighted'   => $request->boolean('highlighted'),
                'show_on_home'  => $request->boolean('show_on_home'),
                'max_discount_percentage' => $request->input('max_discount_percentage') ?? '0',
                'product_id'    => $request->input('product_id'),
            ]);

            # SYNC Images to Media Library when UPDATING
            $discountBox->syncFromMediaLibraryRequest($request->input('cover_image'))
                ->toMediaCollection('cover_image');

            if ($request->input('winner_user_id') !== null  && $discountBox->status === StatusEnum::AWARDED) {
                // Approve the winner transaction
                DiscountRequest::query()
                    ->where('discount_box_id', $discountBox->id)
                    ->where('user_id', $request->input('winner_user_id'))
                    ->where('status', DiscountRequestStatusEnum::PENDING)
                    ->update([
                        'user_id'     => $request->input('winner_user_id'),
                        'status'      => DiscountRequestStatusEnum::APPROVED->value,
                        'approved_at' => now(),
                    ]);

                // Make all other transactions as rejected
                DiscountRequest::query()
                    ->where('discount_box_id', $discountBox->id)
                    ->where('user_id', '!=', $request->input('winner_user_id'))
                    ->where('status', DiscountRequestStatusEnum::PENDING)
                    ->update([
                        'status' => DiscountRequestStatusEnum::REJECTED->value,
                    ]);
            }

            DB::commit();

            FlashNotification::success(__('general.success'), __('discount_box.responses.updated'));
            return ActionJsonResponse::make(true, route('management.discount-boxes.show', ['discountBox' => $discountBox->id]))->response();
        } catch (Exception $exception) {
            report($exception);

            FlashNotification::error(__('general.error'), __('discount_box.responses.not_updated'));
            return ActionJsonResponse::make(false, route('management.discount-boxes.index'))->response();
        }
    }

    public function destroy(DiscountBox $discountBox): RedirectResponse
    {
        $this->authorize('delete', $discountBox);

        try {
            //Delete all the images from the media library, and all the related data
            $discountBox->clearMediaCollection('cover_image');

            $discountBox->delete();

            FlashNotification::success(__('general.success'), __('discount_box.responses.deleted'));
        } catch (Exception $exception) {
            report($exception);
            FlashNotification::error(__('general.error'), __('discount_box.responses.not_deleted'));
        }

        return redirect()->route('management.discount-boxes.index');
    }
}
