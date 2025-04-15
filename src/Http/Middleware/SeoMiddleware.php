<?php

namespace Gyrobus\MoonshineSeo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Gyrobus\MoonshineSeo\Models\Seo;

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
