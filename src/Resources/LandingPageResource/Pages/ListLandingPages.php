<?php

namespace Trov\Resources\LandingPageResource\Pages;

use Trov\Models\LandingPage;
use Trov\Traits\HasCustomTableActions;
use Trov\Resources\LandingPageResource;
use Filament\Resources\Pages\ListRecords;

class ListLandingPages extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = LandingPageResource::class;
}
