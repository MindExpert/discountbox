<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\DiscountBox;
use App\Models\Product;
use App\Models\ProductDiscountRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class DiscountBoxesController extends Controller
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
    public function index(Request $request)
    {
        $discountBoxes = DiscountBox::query()
            ->addSelect(['participants' => ProductDiscountRequest::query()
                ->selectRaw('count(*)')
                ->whereColumn('product_discount_requests.product_id', 'discount_boxes.id')
            ])
            ->with(['media'])
            ->where('discount_boxes.show_on_home', 'true')
            ->orderBy('discount_boxes.created_at', 'DESC')
            ->paginate(12, ['*'], 'discount_boxes_page')
            ->withQueryString();

        return view('frontend.discount-boxes.index', compact('discountBoxes'));
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function indexByStatus(Request $request, StatusEnum $status)
    {
        $discountBoxes = DiscountBox::query()
            ->with(['media'])
            ->where('discount_boxes.status', $status->value)
            //->where('discount_boxes.show_on_home', 'true')
            ->addSelect(['participants' => ProductDiscountRequest::query()
                ->selectRaw('count(*)')
                ->whereColumn('product_discount_requests.product_id', 'discount_boxes.id')
            ])
            ->orderBy('discount_boxes.created_at', 'DESC')
            ->withCount('products')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.discount-boxes.index-by-status', compact('discountBoxes'));
    }

    public function show(DiscountBox $discountBox)
    {
        $discountBox->load('media', 'products');

        return view('frontend.discount-boxes.show', compact('discountBox'));
    }
}
