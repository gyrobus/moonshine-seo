@if($type instanceof \Gyrobus\MoonshineSeo\OpenGraph\Contracts\Type)
    <meta property="og:type" content="{{ $type->getType() }}">
@switch($type::class)
@case(\Gyrobus\MoonshineSeo\OpenGraph\ArticleProperties::class)
    @include('moonshine-seo::open-graph.types.article', compact('type'))
@break
@case(\Gyrobus\MoonshineSeo\OpenGraph\ProfileProperties::class)
    @include('moonshine-seo::open-graph.types.profile', compact('type'))
@break
@case(\Gyrobus\MoonshineSeo\OpenGraph\BookProperties::class)
    @include('moonshine-seo::open-graph.types.book', compact('type'))
@break
@endswitch
@else
    <meta property="og:type" content="{{ $type }}">
@endif
