<?php

namespace App\Filament\Resources\Trov\RunwayResource\Pages;

use Trov\Traits\HasCustomEditActions;
use App\Filament\Resources\Trov\RunwayResource;
use Filament\Resources\Pages\EditRecord;

class EditRunway extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = RunwayResource::class;
}
