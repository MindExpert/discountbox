<?php

namespace App\Http\Controllers;

use App\Enums\DiscountRequestStatusEnum;
use App\Models\DiscountBox;
use App\Models\Product;
use App\Models\DiscountRequest;
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
        $this->middleware('auth')->only(['submitRequestDiscount']);
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
            ->addSelect(['participants' => DiscountRequest::query()
                ->selectRaw('count(*)')
                ->whereColumn('discount_requests.product_id', 'products.id')
                ->where('discount_requests.discount_box_id', $discountBox->id)
            ])
            //->where('products.show_on_home', 'true')
            ->orderBy('products.created_at', 'DESC')
            ->paginate(12, ['*'], 'products_page')
            ->withQueryString();

        return view('frontend.discount-boxes.products.index', compact('discountBox','products'));
    }


}
