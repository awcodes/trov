<?php

namespace Trov\Resources\PostResource\Pages;

use Trov\Models\Post;
use Trov\Resources\PostResource;
use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = PostResource::class;
}
