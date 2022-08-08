<?php

return [
    'default_featured_image' => [
        'url' => '',
        'thumbnail' => '',
        'medium' => '',
        'large' => '',
    ],
    'resources' => [
        'authors' => \Trov\Filament\Resources\AuthorResource::class,
        'pages' => \Trov\Filament\Resources\PageResource::class,
        'posts' => \Trov\Filament\Resources\PostResource::class,
    ],
];
