<?php

namespace Trov\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Trov\Traits\HasCustomEditActions;

class EditPost extends EditRecord
{
    use HasCustomEditActions;

    public static function getResource(): string
    {
        return config('trov.resources.posts');
    }
}
