<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application's locale.
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($locale)
    {
        // Validate locale
        if (!in_array($locale, ['vi', 'zh'])) {
            $locale = 'vi';
        }

        // Store the locale in session
        Session::put('locale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }
}
