<?php

namespace Trov\Resources\AuthorResource\Pages;

use Trov\Models\Author;
use Trov\Resources\AuthorResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\IconButtonAction;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;
}
