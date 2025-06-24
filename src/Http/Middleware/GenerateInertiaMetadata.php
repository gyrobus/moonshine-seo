<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

use function seo;

final class GenerateInertiaMetadata
{
    /**
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // @phpstan-ignore-next-line
        Inertia::share('seo', static fn (): string => (string) seo()->generate());

        return $next($request);
    }
}
