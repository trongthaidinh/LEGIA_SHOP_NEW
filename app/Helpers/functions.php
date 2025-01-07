<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new Setting();
        }

        return Setting::get($key, $default);
    }
}
