<?php

namespace Gyrobus\MoonshineSeo\Fields;

use MoonShine\UI\Fields\Select;

class SelectWithFree extends Select
{
    protected string $view = 'moonshine-seo::fields.select';

    protected function viewData(): array
    {
        $data = parent::viewData();

        return $data;
    }
}
