<?php

namespace Gyrobus\MoonshineSeo\Middleware;

use Closure;
use Gyrobus\MoonshineSeo\Models\Seo;
use Illuminate\Http\Request;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('get')) {
            $seo = Seo::where('path', $request->path())->first();
            seo()
                ->title($seo->title ?? env('APP_NAME'))
                ->description($seo->description ?? env('APP_NAME'));
            if ($seo && $seo->images) seo()->images($seo->images);
        }

        return $next($request);
    }
}
