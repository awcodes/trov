<?php

namespace Trov\Filament\Resources\AuthorResource\Pages;

use Filament\Resources\Pages\EditRecord;

class EditAuthor extends EditRecord
{
    public static function getResource(): string
    {
        return config('trov.resources.authors');
    }
}
