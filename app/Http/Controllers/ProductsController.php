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
    public function index()
    {
        $products = Product::query()
            ->withWhereHas('discount_boxes', function ($query) {
                $query->where('discount_boxes.show_on_home', 'true')
                    ->where('discount_boxes.status', StatusEnum::IN_PROGRESS->value);
            })
            ->where('products.show_on_home', 'true')
            ->orderBy('products.created_at', 'DESC')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('media', 'discount_boxes');

        return view('frontend.products.show', compact('product'));
    }
}
