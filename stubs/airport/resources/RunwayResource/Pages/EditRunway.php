<?php

namespace App\Filament\Resources\Trov\RunwayResource\Pages;

use App\Filament\Resources\Trov\RunwayResource;
use Filament\Resources\Pages\EditRecord;
use Trov\Traits\HasCustomEditActions;

class EditRunway extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = RunwayResource::class;
}
