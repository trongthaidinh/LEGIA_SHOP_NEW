<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

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
        if (in_array($locale, ['vi', 'zh'])) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        // Store the locale in session
        Session::put('locale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }
}
