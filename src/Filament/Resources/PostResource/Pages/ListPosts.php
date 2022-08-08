<?php

namespace Trov\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    public static function getResource(): string
    {
        return config('trov.resources.posts');
    }
}
