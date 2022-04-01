<?php

namespace App\Resources\PostResource\Pages;

use App\Resources\PostResource;
use App\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = PostResource::class;
}
