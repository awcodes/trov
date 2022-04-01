<?php

namespace Trov\Resources\PostResource\Pages;

use Trov\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
