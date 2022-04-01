<?php

namespace Trov\Resources\UserResource\Pages;

use Trov\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
