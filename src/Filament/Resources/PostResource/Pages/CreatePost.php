<?php

namespace Trov\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    public static function getResource(): string
    {
        return config('trov.resources.posts');
    }
}
