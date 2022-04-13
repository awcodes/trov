<?php

return [
    'features' => [
        'authors' => [
            'active' => true,
            'resources' => [
                Trov\Resources\AuthorResource::class,
            ]
        ],
        'posts' => [
            'active' => true,
            'resources' => [
                Trov\Resources\PostResource::class,
            ]
        ],
        'faqs' => [
            'active' => true,
            'resources' => [
                Trov\Resources\FaqResource::class,
            ],
        ],
        'airport' => [
            'active' => true,
            'resources' => [
                Trov\Resources\LandingPageResource::class,
            ],
        ],
        'discovery_center' => [
            'active' => true,
            'resources' => [
                Trov\Resources\DiscoveryTopicResource::class,
                Trov\Resources\DiscoveryArticleResource::class,
            ],
        ],
        'white_pages' => [
            'active' => true,
            'resources' => [
                Trov\Resources\WhitePageResource::class,
            ],
        ],
        'link_sets' => [
            'active' => true,
            'resources' => [
                Trov\Resources\LinkSetResource::class
            ],
        ],
    ],
    'publishable' => [
        'status' => [
            'draft' => 'Draft',
            'review' => 'In Review',
            'published' => 'Published',
        ],
        'colors' => [
            'primary',
            'danger' => 'draft',
            'warning' => 'review',
            'success' => 'published'
        ],
    ],
    'linkable_sets_sections' => [
        'Types of Services' => 'Types of Services',
        'How to Get Cash' => 'How to Get Cash',
        'Near Me' => 'Near Me'
    ],
    'default_featured_image' => [
        'url' => 'https://res.cloudinary.com/tmxfoc/image/upload/v1600976413/tmxfinancefamily/opengraph.jpg',
        'thumbnail_url' => 'https://res.cloudinary.com/tmxfoc/image/upload/f_auto,q_auto,c_fill,w_200,h_200/tmxfinancefamily/opengraph.jpg',
        'medium_url' => 'https://res.cloudinary.com/tmxfoc/image/upload/f_auto,q_auto,c_fill,w_640/tmxfinancefamily/opengraph.jpg',
        'large_url' => 'https://res.cloudinary.com/tmxfoc/image/upload/f_auto,q_auto,c_fill,w_1024/tmxfinancefamily/opengraph.jpg',
    ],
];
