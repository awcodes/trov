<?php

namespace App\Resources\WhitePageResource\Pages;

use App\Models\WhitePage;
use App\Resources\WhitePageResource;
use App\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;

class ListWhitePages extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = WhitePageResource::class;
}
