<?php

namespace App\Resources\LandingPageResource\Pages;

use App\Traits\HasCustomEditActions;
use App\Resources\LandingPageResource;
use Filament\Resources\Pages\EditRecord;

class EditLandingPage extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = LandingPageResource::class;
}
