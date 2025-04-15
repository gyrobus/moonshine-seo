<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Resources;

use Gyrobus\MoonshineCropper\Fields\Cropper;
use Illuminate\Database\Eloquent\Model;
use Gyrobus\MoonshineSeo\Models\Seo;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

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
            Cropper::make('Картинка', 'image'),
            Text::make('Адрес страницы', 'path'),
            Text::make('Заголовок', 'title'),
            Text::make('Описание', 'description'),
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
                Cropper::make('Картинка', 'image')
                    ->disk('public')
                    ->dir('seo'),
                Text::make('Адрес страницы', 'path'),
                Text::make('Заголовок', 'title'),
                Text::make('Описание', 'description'),
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
            Cropper::make('Картинка', 'image'),
            Text::make('Адрес страницы', 'path'),
            Text::make('Заголовок', 'title'),
            Text::make('Описание', 'description'),
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
}
