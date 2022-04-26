<?php

namespace App\Filament\Resources\Trov\UserResource\Pages;

use App\Filament\Resources\Trov\UserResource;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
