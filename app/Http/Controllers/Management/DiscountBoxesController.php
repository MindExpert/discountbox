<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Management\ProductStoreRequest;
use App\Http\Requests\Management\ProductUpdateRequest;
use App\Models\DiscountBox;
use App\Models\Product;
use App\Models\User;
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
                    ->with(['media'])
                    ->select(['discount_boxes.*']);

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
                    ->editColumn('name', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.name', compact('discountBox')))
                    ->editColumn('status', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.status', compact('discountBox')))
                    ->editColumn('highlighted', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.highlighted', compact('discountBox')))
                    ->editColumn('show_on_home', fn(DiscountBox $discountBox) => view('management.discount-boxes.datatable.show_on_home', compact('discountBox')))
                    ->addColumn('actions', 'management.products.datatable.actions')
                    ->rawColumns(['actions', 'image', 'name', 'status', 'highlighted', 'show_on_home'])
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

    public function store(ProductStoreRequest $request): JsonResponse
    {
        $this->authorize('create', DiscountBox::class);

        try {
            DB::beginTransaction();

            /** @var DiscountBox $discountBox */
            $discountBox = DiscountBox::query()->create([
                'user_id'       => user()->id,
                'coupon_id'     => $request->input('coupon_id'),
                'name'          => $request->input('name'),
                'price'         => $request->input('price'),
                'discount'      => (10 * 2), #TODO: To be calculate based on the coupon, if is present
                'total'         => (100 - (10 * 2)), #TODO: To be calculate based on the coupon, if is present,
                'expires_at'    => $request->boolean('expires_at'),
                'status'        => $request->input('status'),
                'highlighted'   => $request->boolean('highlighted'),
                'show_on_home'  => $request->boolean('show_on_home'),
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

        $discountBox->load(['media']);

        return view('management.discount-boxes.edit', compact('discountBox'));
    }

    public function update(ProductUpdateRequest $request, DiscountBox $discountBox): JsonResponse
    {
        $this->authorize('update', $discountBox);

        try {
            DB::beginTransaction();

            $discountBox->update([
                'coupon_id'     => $request->input('coupon_id'),
                'name'          => $request->input('name'),
                'price'         => $request->input('price'),
                'discount'      => (10 * 2), #TODO: To be calculate based on the coupon, if is present
                'total'         => (100 - (10 * 2)), #TODO: To be calculate based on the coupon, if is present,
                'expires_at'    => $request->boolean('expires_at'),
                'status'        => $request->input('status'),
                'highlighted'   => $request->boolean('highlighted'),
                'show_on_home'  => $request->boolean('show_on_home'),
            ]);

            # SYNC Images to Media Library when UPDATING
            $discountBox->syncFromMediaLibraryRequest($request->input('cover_image'))
                ->toMediaCollection('cover_image');

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
            #TODO: Delete all the images from the media library, and all the related data

            $discountBox->delete();

            FlashNotification::success(__('general.success'), __('discount_box.responses.deleted'));
        } catch (Exception $exception) {
            report($exception);
            FlashNotification::error(__('general.error'), __('discount_box.responses.not_deleted'));
        }

        return redirect()->route('management.discount-boxes.index');
    }
}
