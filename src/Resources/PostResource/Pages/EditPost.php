<?php

namespace Trov\Resources\PostResource\Pages;

use Trov\Resources\PostResource;
use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = PostResource::class;
}
