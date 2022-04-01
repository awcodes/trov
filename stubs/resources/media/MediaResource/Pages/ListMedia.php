<?php

namespace App\Resources\MediaResource\Pages;

use App\Resources\MediaResource;
use Filament\Resources\Pages\ListRecords;

class ListMedia extends ListRecords
{
    protected static string $resource = MediaResource::class;
}
