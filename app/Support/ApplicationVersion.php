<?php

namespace App\Support;

use Exception;
use Illuminate\Support\Facades\Cache;

class ApplicationVersion
{
    private const CACHE_KEY = 'APP_VERSION';

    public static function get()
    {
        if (! Cache::has(self::CACHE_KEY)) {
            try {
                $version = trim(exec('git describe --tags --abbrev=0'));

                if (empty($version)) {
                    $version = 'v.'.trim(exec('git rev-parse --short HEAD'));
                } else {
                    $version = 'v.'.$version;
                }
            } catch (Exception) {
                $version = 'v.0.0.0';
            }

            Cache::put(self::CACHE_KEY, $version);
        }

        return Cache::get(self::CACHE_KEY);
    }
}
