<?php

return [
    'gtm' => env('GTM_ID'),
    'name' => null,
    'display' => null,
    'source' => null,
    'slug' => null,
    'phone' => null,
    'vanity' => null,
    'email' => 'webinquiries@titlemax.com',
    'apps' => [
        'account' => env('APPS_ACCOUNT'),
        'ecomm' => env('APPS_ECOMM'),
        'android' => env('APPS_ANDROID'),
        'ios' => env('APPS_IOS'),
    ],
    'ola_token' => null,
    'images' => [
        'logo' => [
            'url' => null,
            'alt' => null,
        ],
        'logo_reversed' => [
            'url' => null,
            'alt' => null,
        ],
        'logo_white' => [
            'url' => null,
            'alt' => null,
        ],
        'icon' => [
            'url' => null,
            'alt' => null,
        ],
        'default_store' => [
            'url' => null,
            'alt' => null,
        ],
        'opengraph' => [
            'url' => null,
            'alt' => null,
        ],
        'map_marker' => null,
        'map_marker_aa' => null,
    ],
    'facebook' => [
        'label' => 'Facebook',
        'handle' => null,
    ],
    'twitter' => [
        'label' => 'Twitter',
        'handle' => null,
    ],
    'instagram' => [
        'label' => 'Instagram',
        'handle' => null,
    ],
    'pinterest' => [
        'label' => 'Pinterest',
        'handle' => null,
    ],
    'youtube' => [
        'label' => 'YouTube',
        'handle' => null,
    ],
];
