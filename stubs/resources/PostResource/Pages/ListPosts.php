<?php

namespace App\Filament\Resources\Trov\PostResource\Pages;

use App\Filament\Resources\Trov\PostResource;
use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = PostResource::class;
}
