{{--<div x-data="{ custom: '' }">
    <select name="category" x-show="!custom">
        <option value="">Выбери из списка</option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
        <option value="custom">Другое...</option>
    </select>
    <input type="text" name="category_custom" x-show="custom" x-model="custom">
</div>--}}

@props([
    'value' => '',
    'values' => [],
    'isNullable' => false,
    'isSearchable' => false,
    'asyncUrl' => '',
    'isNative' => false,
])
<x-moonshine-seo::select
        :attributes="$attributes"
        :values="$values"
        :nullable="$isNullable"
        :searchable="$isSearchable"
        :asyncRoute="$asyncUrl"
        :native="$isNative"
/>