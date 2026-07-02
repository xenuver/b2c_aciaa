<?php

namespace App\Helpers;

use App\Models\StoreSetting;

class SettingHelper
{
    public static function get($key, $default = null)
    {
        $setting = StoreSetting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}