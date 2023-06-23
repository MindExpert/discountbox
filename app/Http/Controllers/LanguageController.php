<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageUpdateRequest;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class LanguageController
{
    public function __invoke(LanguageUpdateRequest $request)
    {
         try {
             $locale = $request->input('locale');

             App::setLocale($locale);
             Carbon::setLocale($locale);

             session()->put('locale', $locale);

             FlashNotification::success(__('general.success'), __('user.responses.locale_updated'));
         } catch (Exception $e) {
             report($e);
             FlashNotification::error(__('general.error'), __('user.responses.locale_not_updated'));
         }

         return redirect()->back();

        //try {
        //    user()->update([
        //        'locale' => $request->input('locale'),
        //    ]);
        //    FlashNotification::success(__('general.success'), __('user.responses.locale_updated'));
        //} catch (Exception $e) {
        //    report($e);
        //    FlashNotification::error(__('general.error'), __('user.responses.locale_not_updated'));
        //}
        //return redirect()->back();
    }
}
