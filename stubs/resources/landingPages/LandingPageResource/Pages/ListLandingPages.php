<?php

namespace App\Resources\LandingPageResource\Pages;

use App\Models\LandingPage;
use App\Traits\HasCustomTableActions;
use App\Resources\LandingPageResource;
use Filament\Resources\Pages\ListRecords;

class ListLandingPages extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = LandingPageResource::class;
}
