<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Resources;

use Gyrobus\MoonshineCropper\Fields\Cropper;
use Illuminate\Database\Eloquent\Model;
use Gyrobus\MoonshineSeo\Models\Seo;
use Illuminate\Support\Facades\Route;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Seo>
 */
class SeoResource extends ModelResource
{
    protected string $model = Seo::class;

    protected string $title = 'Seo данные';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            $this->getCropperField(),
            Text::make('Адрес страницы', 'path'),
            Text::make('Заголовок', 'title'),
            Textarea::make('Описание', 'description'),
        ];
    }

    /**
     * @return FieldContract
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                $this->getCropperField(),
                $this->getUrlField(),
                Text::make('Заголовок', 'title'),
                Textarea::make('Описание', 'description'),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            $this->getCropperField(),
            Text::make('Адрес страницы', 'path'),
            Text::make('Заголовок', 'title'),
            Textarea::make('Описание', 'description'),
        ];
    }

    /**
     * @param Seo $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

    protected function getCropperField(): Cropper
    {
        $field = Cropper::make('Картинка', 'image')
            ->disk(config('moonshine-seo.image.disk', 'public'))
            ->dir('seo');

        if (config('moonshine-seo.image.dir')) $field->dir(config('moonshine-seo.image.dir'));

        return $field;
    }

    protected function getUrlField()
    {
        return config('moonshine-seo.url.select', false)
            ? Select::make('Адрес страницы', 'path')
                ->options($this->getSelectRouteOptions())
            : Text::make('Адрес страницы', 'path');
    }

    protected function getSelectRouteOptions(): array
    {
        $accept = config('moonshine-seo.routes.controller.accept', []);
        $reject = config('moonshine-seo.routes.controller.reject', []);
        $acceptMask = config('moonshine-seo.routes.controller.acceptMask');
        $rejectMask = config('moonshine-seo.routes.controller.rejectMask');

        return collect(Route::getRoutes())
            ->filter(function ($route) use ($accept, $reject, $acceptMask, $rejectMask) {
                $controller = $route->action['controller'] ?? null;

                if (!in_array('GET', $route->methods()) || !isset($controller)) {
                    return false;
                }

                if ((!empty($reject) && in_array($controller, $reject)) || (!is_null($rejectMask) && is_string($rejectMask) && preg_match($rejectMask, $controller))) {
                    return false;
                }

                if (empty($accept) && (is_null($acceptMask) || !is_string($acceptMask))) {
                    return true;
                }

                return (!empty($accept) && in_array($controller, $accept)) || (!is_null($acceptMask) && is_string($acceptMask) && preg_match($acceptMask, $controller));
            })
            ->map(function ($route) {
                $uri = $route->uri();
                $path = !str_starts_with($uri, '/') ? '/' . $uri : $uri;
                return [$path => $path];
            })
            ->mapWithKeys(function ($item) {
                return $item;
            })
            ->toArray();
    }
}
