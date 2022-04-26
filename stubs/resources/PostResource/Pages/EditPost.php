<?php

namespace App\Filament\Resources\Trov\PostResource\Pages;

use App\Filament\Resources\Trov\PostResource;
use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = PostResource::class;
}
