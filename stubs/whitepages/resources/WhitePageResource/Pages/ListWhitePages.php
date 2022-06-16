<?php

namespace App\Filament\Resources\Trov\WhitePageResource\Pages;

use App\Filament\Resources\Trov\WhitePageResource;
use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;

class ListWhitePages extends ListRecords
{
    protected static string $resource = WhitePageResource::class;
}
