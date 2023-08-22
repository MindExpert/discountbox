<?php

namespace App\Http\Controllers;

use App\Enums\ProductDiscountRequestStatusEnum;
use App\Models\DiscountBox;
use App\Models\Product;
use App\Models\ProductDiscountRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all products for the given discountbox.
     *
     * @return Renderable
     */
    public function index(DiscountBox $discountBox)
    {
        $products = Product::query()
            ->with(['media'])
            ->withWhereHas('discount_boxes', function ($query) use ($discountBox) {
                $query->where('discount_boxes.id', $discountBox->id);
            })
            //->where('products.show_on_home', 'true')
            ->orderBy('products.created_at', 'DESC')
            ->paginate(12, ['*'], 'products_page')
            ->withQueryString();

        return view('frontend.discount-boxes.products.index', compact('discountBox','products'));
    }

    /**
     * Display the specified product of the discountbox.
     * @param DiscountBox $discountBox
     * @param Product $product
     * @return View
     */
    public function show(DiscountBox $discountBox, Product $product)
    {
        $product = $discountBox->products()
            ->with('media')
            ->where('products.id', $product->id)
            ->firstOrFail();

        $product->setRelation('discount_box', $discountBox);

        $discountBox->load('coupon');

        $userAvailableCredit = auth()->user()->availableBalance();

        return view('frontend.discount-boxes.products.show', compact('discountBox', 'product', 'userAvailableCredit'));
    }

    /**
     * Display the specified product of the discountbox.
     * @param Request $request
     * @param DiscountBox $discountBox
     * @param Product $product
     * @return JsonResponse
     */
    public function submitRequestDiscount(Request $request, DiscountBox $discountBox, Product $product): JsonResponse
    {
        /** @var Product $product */
        $product = $discountBox->products()
            ->with('media')
            ->where('products.id', $product->id)
            ->firstOrFail();

        $userAvailableCredit = user()->availableBalance();

        if ($userAvailableCredit < $request->input('credit')) {
            return response()->json([
                'success' => false,
                'message' => __('You do not have enough credit to request this discount.'),
            ], 422);
        }

        $requestExists = ProductDiscountRequest::query()
            ->where('user_id', user()->id)
            ->where('product_id', $product->id)
            ->where('discount_box_id', $discountBox->id)
            //->where('status', ProductDiscountRequestStatusEnum::PENDING)
            ->exists();

        if ($requestExists) {
            return response()->json([
                'success' => false,
                'message' => __('You have already requested a submission for this discount.'),
            ], 422);
        }

        /** @var ProductDiscountRequest $productDiscountRequest */
        $productDiscountRequest = ProductDiscountRequest::query()
            ->create([
                'user_id'         => user()->id,
                'product_id'      => $product->id,
                'discount_box_id' => $discountBox->id,
                'credit'          => $request->input('credit'),
                'status'          => ProductDiscountRequestStatusEnum::PENDING,
            ]);

        return response()->json([
            'success' => true,
            'message' => __('Your request has been submitted successfully.'),
            'data'    => $productDiscountRequest,
        ], 200);
    }
}
