<?php

namespace Trov\Filament\Resources\PageResource\Pages;

use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    use HasCustomEditActions;

    public static function getResource(): string
    {
        return config('trov.resources.pages');
    }
}
