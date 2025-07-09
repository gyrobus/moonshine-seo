<?php

declare(strict_types=1);

use Gyrobus\MoonshineSeo\Generators;

return [

    'routes' => [
        'select' => true,
        'controller' => [
            'accept' => [],
            'reject' => [],
            'acceptMask' => null, // example: '/^App\\\\Http\\\\Controllers\\\\(Blog|Comment)Controller$/'
            'rejectMask' => null, // example: '/^App\\\\Http\\\\Controllers\\\\(Blog|Comment)Controller$/'
        ]
    ],

    'image' => [
        'disk' => env('MOONSHINE_SEO_DISK', 'public'),
        'dir' => env('MOONSHINE_SEO_DIR', 'seo'),
        'default' => env('MOONSHINE_SEO_DEFAULT_IMAGE'),
    ],

    'generators' => [
        Generators\MetaGenerator::class => [
            'title' => env('APP_NAME'),
            'titleTemplate' => '{title} - '.env('APP_NAME'),
            'description' => '',
            'keywords' => [],
            'canonicalEnabled' => true,
            'canonical' => null, // null to use current url
            'robots' => [],
            'custom' => [
                // [
                //     'greeting' => 'Hey, thanks for checking out the source code of our website. '.
                //         'Hopefully you find what you are looking for 👍'
                // ],
                // [
                //     'google-site-verification' => 'xxx',
                // ],
            ],
        ],
        Generators\TwitterGenerator::class => [
            'enabled' => true,
            'site' => '', // @twitterUsername
            'card' => 'summary_large_image',
            'creator' => '',
            'creatorId' => '',
            'title' => '',
            'description' => '',
            'image' => '',
            'imageAlt' => '',
        ],
        Generators\OpenGraphGenerator::class => [
            'enabled' => true,
            'site' => env('APP_NAME'),
            'type' => 'website',
            'title' => '',
            'description' => '',
            'images' => [],
            'audio' => [],
            'videos' => [],
            'determiner' => '',
            'url' => null, // null to use current url
            'locale' => '',
            'alternateLocales' => [],
            'custom' => [],
        ],
        Generators\JsonLdGenerator::class => [
            'enabled' => true,
            'pretty' => env('APP_DEBUG'),
            'type' => 'WebPage',
            'name' => '',
            'description' => '',
            'images' => [],
            'url' => null, // null to use current url
            'custom' => [],

            // determines if the configured json-ld is automatically placed on the graph
            'place-on-graph' => true,
        ],
    ],

    'sync' => [
        'url-canonical' => true,
        'keywords-tags' => false,
    ],
];