<?php

namespace Trov\Resources\AuthorResource\Pages;

use Trov\Resources\AuthorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;
}
