<?php

namespace App\Filament\Resources\Trov\PostResource\Pages;

use App\Filament\Resources\Trov\PostResource;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;
}
