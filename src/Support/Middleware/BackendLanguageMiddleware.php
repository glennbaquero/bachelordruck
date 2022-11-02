<?php

namespace Support\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Support\Helpers\UserLanguageSessionHelper;

class BackendLanguageMiddleware
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
        App::setLocale(UserLanguageSessionHelper::get());

        return $next($request);
    }
}
