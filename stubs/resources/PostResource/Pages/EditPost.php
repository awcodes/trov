<?php

namespace App\Filament\Resources\Trov\PostResource\Pages;

use App\Filament\Resources\Trov\PostResource;
use Filament\Resources\Pages\EditRecord;
use Trov\Traits\HasCustomEditActions;

class EditPost extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = PostResource::class;
}
