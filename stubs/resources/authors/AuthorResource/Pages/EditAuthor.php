<?php

namespace App\Resources\AuthorResource\Pages;

use App\Resources\AuthorResource;
use Filament\Resources\Pages\EditRecord;

class EditAuthor extends EditRecord
{
    protected static string $resource = AuthorResource::class;
}
