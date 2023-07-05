<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Management\ProductStoreRequest;
use App\Http\Requests\Management\ProductUpdateRequest;
use App\Http\Requests\Management\UserStoreRequest;
use App\Http\Requests\Management\UserUpdateRequest;
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
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $this->authorize('viewAny', Product::class);

        if ($request->ajax() || $request->wantsJson()) {
            try {

                $datatableQuery = Product::query()
                    ->with(['media'])
                    ->select(['products.*']);

                return DataTables::eloquent($datatableQuery)
                    ->addColumn('permissions', function (Product $product) {
                        $view   = user()->can('view', $product);
                        $update = user()->can('update', $product);
                        $delete = user()->can('delete', $product);

                        return [
                            'view'   => $view,
                            'update' => $update,
                            'delete' => $delete,
                        ];
                    })
                    ->addColumn('image', fn(Product $product) => view('management.products.datatable.image', compact('product'))->render())
                    ->editColumn('name', function(Product $product) {
                        if (! empty($product->description)) {
                            $html = nl2br($product->description);
                        } else {
                            $html = __('general.no_data');
                        }
                        return view('management.products.datatable.name', compact('product', 'html'));
                        //return view('management.products.datatable.name', compact('product'))->render();
                    })
                    ->editColumn('status', fn(Product $product) => view('management.products.datatable.status', compact('product')))
                    ->editColumn('highlighted', fn(Product $product) => view('management.products.datatable.highlighted', compact('product')))
                    ->editColumn('show_on_home', fn(Product $product) => view('management.products.datatable.show_on_home', compact('product')))
                    ->addColumn('actions', 'management.products.datatable.actions')
                    ->rawColumns(['actions', 'image', 'name', 'status', 'highlighted', 'show_on_home'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return EmptyDatatable::toJson();
            }
        }

        return view('management.products.index');
    }

    public function search(Request $request): JsonResponse
    {
        $this->authorize('search', Product::class);

        return response()->json(
            Product::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()->append(['label', 'thumbnail'])
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
        /** @var Product|null $product */
        $product = Product::query()
            ->with('media')
            ->where('id', $request->input('model_id'))
            ->firstOrFail();

        $this->authorize('view', $product);

        $redirectTo = $request->get('redirect_to');

        $modalDetails = view('management.products._partials.product-image-modal', compact('product', 'redirectTo'))->render();

        return response()->json([
            'data' => [
                'model_id' => $product->id,
                'details'  => $modalDetails,
            ],
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Product::class);

        return view('management.products.create');
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        try {
            DB::beginTransaction();

            /** @var Product $product */
            $product = Product::query()->create([
                'user_id'       => user()->id,
                'name'          => $request->input('name'),
                'url'           => $request->input('url'),
                'description'   => $request->input('description'),
                'review'        => $request->input('review'),
                //'status'        => $request->input('status'),
                'highlighted'   => $request->boolean('highlighted'),
                'show_on_home'  => $request->boolean('show_on_home'),
            ]);

            # ADD Images to Media Library when creating
            if ($request->input('featured_image') !== null) {
                $product->addFromMediaLibraryRequest($request->input('featured_image'))
                    ->toMediaCollection('featured_image');
            }

            if ($request->input('gallery_images') !== null) {
                $product->addFromMediaLibraryRequest($request->input('gallery_images'))
                    ->toMediaCollection('gallery_images');
            }

            DB::commit();

            FlashNotification::success(__('general.success'), __('product.responses.created'));
            return ActionJsonResponse::make(true, route('management.products.show', ['product' => $product->id]))->response();
        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();

            FlashNotification::error(__('general.error'), __('product.responses.not_created'));
            return ActionJsonResponse::make(false, route('management.products.index'))->response();
        }
    }

    public function show(Product $product): View
    {
        $this->authorize('view', $product);

        return view('management.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        $product->load(['media']);

        return view('management.products.edit', compact('product'));
    }

    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $this->authorize('update', $product);

        try {
            DB::beginTransaction();

            $product->update([
                'name'          => $request->input('name'),
                'url'           => $request->input('url'),
                'description'   => $request->input('description'),
                'review'        => $request->input('review'),
                'highlighted'   => $request->boolean('highlighted'),
                'show_on_home'  => $request->boolean('show_on_home'),
                //'status'        => $request->input('status'),
            ]);

            # SYNC Images to Media Library when UPDATING
            $product->syncFromMediaLibraryRequest($request->input('featured_image'))
                ->toMediaCollection('featured_image');

            $product->syncFromMediaLibraryRequest($request->input('gallery_images'))
                ->toMediaCollection('gallery_images');

            DB::commit();

            FlashNotification::success(__('general.success'), __('product.responses.updated'));
            return ActionJsonResponse::make(true, route('management.products.show', ['product' => $product->id]))->response();
        } catch (Exception $exception) {
            report($exception);

            FlashNotification::error(__('general.error'), __('product.responses.not_updated'));
            return ActionJsonResponse::make(false, route('management.products.index'))->response();
        }

    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        try {
            $product->delete();

            FlashNotification::success(__('general.success'), __('product.responses.deleted'));
        } catch (Exception $exception) {
            report($exception);
            FlashNotification::error(__('general.error'), __('product.responses.not_deleted'));
        }

        return redirect()->route('management.products.index');
    }

}
