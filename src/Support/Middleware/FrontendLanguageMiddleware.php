<?php

namespace Support\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Support\Helpers\FrontendLanguageHelper;

class FrontendLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $helper = app(FrontendLanguageHelper::class);
        $language = $helper->get();
        App::setLocale($language->languageCode);

        return $next($request);
    }
}
