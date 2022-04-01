<?php

namespace Trov\Resources\LandingPageResource\Pages;

use Trov\Traits\HasCustomEditActions;
use Trov\Resources\LandingPageResource;
use Filament\Resources\Pages\EditRecord;

class EditLandingPage extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = LandingPageResource::class;
}
