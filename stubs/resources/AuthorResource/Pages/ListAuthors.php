<?php

namespace App\Filament\Resources\Trov\AuthorResource\Pages;

use App\Filament\Resources\Trov\AuthorResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\IconButtonAction;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;
}
