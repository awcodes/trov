<?php

namespace App\Resources\PostResource\Pages;

use App\Models\Post;
use App\Resources\PostResource;
use App\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = PostResource::class;
}
