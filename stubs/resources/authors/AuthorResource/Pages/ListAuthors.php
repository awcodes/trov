<?php

namespace App\Resources\AuthorResource\Pages;

use App\Models\Author;
use App\Resources\AuthorResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\IconButtonAction;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;
}
