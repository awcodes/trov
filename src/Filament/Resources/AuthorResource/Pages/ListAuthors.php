<?php

namespace Trov\Filament\Resources\AuthorResource\Pages;

use Filament\Resources\Pages\ListRecords;

class ListAuthors extends ListRecords
{
    public static function getResource(): string
    {
        return config('trov.resources.authors');
    }
}
