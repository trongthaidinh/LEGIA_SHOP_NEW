<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get locale from URL segment
        $locale = $request->segment(1);
        
        // Check if locale is valid
        if (in_array($locale, ['vi', 'zh'])) {
            App::setLocale($locale);
            URL::defaults(['locale' => $locale]);
        } else {
            // Redirect to default locale if no valid locale in URL
            $segments = $request->segments();
            $defaultLocale = config('app.locale', 'vi');
            
            if (empty($segments)) {
                return redirect()->to('/' . $defaultLocale);
            }
            
            return redirect()->to('/' . $defaultLocale . '/' . implode('/', $segments));
        }

        return $next($request);
    }
}
