<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\DiscountBox;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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

        /** @var DiscountBox $discountBoxInProgress */
        $discountBoxInProgress = DiscountBox::query()
            ->where('discount_boxes.show_on_home', 'true')
            ->where('status', StatusEnum::IN_PROGRESS->value)
            ->orderBy('discount_boxes.created_at', 'DESC')
            ->withWhereHas('products', function ($query) {
                $query
                    ->with('media')
                    //->where('products.show_on_home', 'true')
                    ->orderBy('products.created_at', 'DESC')->limit(6);
            })
            ->first();

        /** @var DiscountBox $discountBoxAwarded */
        $discountBoxAwarded = DiscountBox::query()
            ->where('discount_boxes.show_on_home', 'true')
            ->where('status', StatusEnum::AWARDED->value)
            ->orderBy('discount_boxes.created_at', 'DESC')
            ->withWhereHas('products', function ($query) {
                $query
                    ->with('media')
                    //->where('products.show_on_home', 'true')
                    ->orderBy('products.created_at', 'DESC')->limit(6);
            })
            ->first();

        /** @var DiscountBox $discountBoxConcluded */
        $discountBoxConcluded = DiscountBox::query()
            ->where('discount_boxes.show_on_home', 'true')
            ->where('status', StatusEnum::CONCLUDED->value)
            ->orderBy('discount_boxes.created_at', 'DESC')
            ->withWhereHas('products', function ($query) {
                $query
                    ->with('media')
                    //->where('products.show_on_home', 'true')
                    ->orderBy('products.created_at', 'DESC')->limit(6);
            })
            ->first();

        return view('welcome', compact('discountBoxInProgress', 'discountBoxAwarded', 'discountBoxConcluded'));
    }
}
