<?php

namespace App\Filament\Resources\Trov\RunwayResource\Pages;

use Trov\Traits\HasCustomTableActions;
use App\Filament\Resources\Trov\RunwayResource;
use Filament\Resources\Pages\ListRecords;

class ListRunways extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = RunwayResource::class;
}
