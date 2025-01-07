<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (in_array($lang, ['vn', 'cn'])) {
            session(['locale' => $lang]);
        }
        return redirect()->back();
    }
}
