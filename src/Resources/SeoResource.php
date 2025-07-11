<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Resources;

use Gyrobus\MoonshineCropper\Fields\Cropper;
use Gyrobus\MoonshineSeo\Models\Seo;
use Illuminate\Support\Facades\Route;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Seo>
 */
class SeoResource extends ModelResource
{
    protected string $model = Seo::class;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return __('moonshine-seo::resource.title');
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            $this->getCropperField(),
            Text::make(__('moonshine-seo::resource.fields.path'), 'path'),
            Text::make(__('moonshine-seo::resource.fields.title'), 'title'),
            Textarea::make(__('moonshine-seo::resource.fields.description'), 'description'),
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
                Text::make(__('moonshine-seo::resource.fields.title'), 'title'),
                Textarea::make(__('moonshine-seo::resource.fields.description'), 'description'),
                Json::make(__('moonshine-seo::resource.meta.title'), 'meta')->fields([
                    Text::make(__('moonshine-seo::resource.meta.name'), 'name'),
                    Textarea::make(__('moonshine-seo::resource.meta.content'), 'content'),
                ])
                    ->creatable()
                    ->removable()
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
            Text::make(__('moonshine-seo::resource.fields.path'), 'path'),
            Text::make(__('moonshine-seo::resource.fields.title'), 'title'),
            Textarea::make(__('moonshine-seo::resource.fields.description'), 'description'),
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
        return [
            'meta' => 'nullable|array',
            'meta.*.name' => 'required|string',
            'meta.*.content' => 'required|string',
        ];
    }

    protected function getCropperField(): Cropper
    {
        $field = Cropper::make(__('moonshine-seo::resource.fields.image'), 'image')
            ->disk(config('moonshine-seo.image.disk', 'public'))
            ->dir('seo');

        if (config('moonshine-seo.image.dir')) $field->dir(config('moonshine-seo.image.dir'));

        return $field;
    }

    protected function getUrlField()
    {
        return config('moonshine-seo.routes.select', false)
            ? Select::make(__('moonshine-seo::resource.fields.path'), 'path')
                ->options($this->getSelectRouteOptions())
                ->searchable()
            : Text::make(__('moonshine-seo::resource.fields.path'), 'path');
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

                if (strpos($controller, '@') > 0) $controller = explode('@', $controller)[0];

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
