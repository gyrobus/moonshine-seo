@if($card instanceof \Gyrobus\MoonshineSeo\Twitter\Contracts\Card)
    <meta name="twitter:card" content="{{ $card->getName() }}">
@switch($card::class)
@case(\Gyrobus\MoonshineSeo\Twitter\AppProperties::class)
    @include('moonshine-seo::twitter.cards.app', compact('card'))
@break
@case(\Gyrobus\MoonshineSeo\Twitter\PlayerProperties::class)
    @include('moonshine-seo::twitter.cards.player', compact('card'))
@endswitch
@else
    <meta name="twitter:card" content="{{ $card }}">
@endif
