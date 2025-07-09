<?php

namespace Gyrobus\MoonshineSeo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Gyrobus\MoonshineSeo\Models\Seo;
use Illuminate\Support\Facades\Storage;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('get')) {

            $seo = Seo::where('path', $request->path())->first();

            seo()
                ->title($seo->title ?? env('APP_NAME'))
                ->description($seo->description ?? env('APP_NAME'));

            if ($seo && $seo->image) {
                $storage = Storage::disk(config('moonshine-seo.image.disk', 'public'));
                if ($storage->exists($seo->image)) {
                    seo()->images($storage->url($seo->image));
                }
            }

        }

        return $next($request);
    }
}
