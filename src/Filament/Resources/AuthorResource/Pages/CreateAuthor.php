<?php

namespace Trov\Filament\Resources\AuthorResource\Pages;

use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    public static function getResource(): string
    {
        return config('trov.resources.authors');
    }
}
