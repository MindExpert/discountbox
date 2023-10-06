<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DiscountBox;
use App\Models\Product;
use App\Models\User;
use App\Support\ActionJsonResponse;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        /** @var DiscountBox $discountBoxInProgress */
        $discountBoxInProgress = DiscountBox::query()
            ->where('discount_boxes.show_on_home', 'true')
            ->where('status', StatusEnum::IN_PROGRESS->value)
            ->withCount('discount_requests')
            ->orderBy('discount_boxes.created_at', 'DESC')
            ->withWhereHas('product', function ($query) {
                $query->with('media');
            })
            ->take(6)
            ->get();

        /** @var DiscountBox $discountBoxAwardedAndConcluded */
        $discountBoxAwardedAndConcluded = DiscountBox::query()
            ->where('discount_boxes.show_on_home', 'true')
            ->whereIn('status', [StatusEnum::AWARDED->value, StatusEnum::CONCLUDED->value])
            ->withCount('discount_requests')
            ->orderBy('discount_boxes.created_at', 'DESC')
            ->withWhereHas('product', function ($query) {
                $query->with('media');
            })
            ->take(6)
            ->get();

        return view('welcome', compact('discountBoxInProgress', 'discountBoxAwardedAndConcluded'));
    }

    public function howItWorks(Request $request)
    {
        return view('frontend.how-it-works');
    }

    public function testimonials(Request $request)
    {
        return view('frontend.testimonials');
    }

    public function partners(Request $request)
    {
        return view('frontend.partners');
    }
}
