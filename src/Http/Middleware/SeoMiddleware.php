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

            if ($seo) {

                if ($seo->image) {

                    $storage = Storage::disk(config('moonshine-seo.image.disk', 'public'));

                    if ($storage->exists($seo->image)) {
                        seo()->images($storage->url($seo->image));
                    } else {
                        $this->setDefaultImage();
                    }

                }

                if ($seo->meta) {
                    foreach ($seo->meta as $meta) {
                        seo()->metaTag($meta->name, $meta->content);
                    }
                }

            } else {
                $this->setDefaultImage();
            }

        }

        return $next($request);
    }

    protected function setDefaultImage()
    {
        if (config('moonshine-seo.image.default')) {
            seo()->images(asset(config('moonshine-seo.image.default')));
        }
    }
}
