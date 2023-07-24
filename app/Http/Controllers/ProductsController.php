<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\DiscountBox;
use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
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
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(DiscountBox $discountBox)
    {
        $products = Product::query()
            ->withWhereHas('discount_boxes', function ($query) use ($discountBox) {
                $query->where('discount_boxes.id', $discountBox->id);
            })
            //->where('products.show_on_home', 'true')
            ->orderBy('products.created_at', 'DESC')
            ->paginate(12, ['*'], 'products_page')
            ->withQueryString();

        return view('frontend.discount-boxes.products.index', compact('discountBox','products'));
    }

    public function show(DiscountBox $discountBox, Product $product)
    {
        $product = $discountBox->products()
            ->with('media')
            ->where('products.id', $product->id)
            ->firstOrFail();

        return view('frontend.discount-boxes.products.show', compact('discountBox', 'product'));
    }
}
