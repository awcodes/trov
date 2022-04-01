<?php

namespace Trov\Resources\WhitePageResource\Pages;

use Trov\Models\WhitePage;
use Trov\Resources\WhitePageResource;
use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;

class ListWhitePages extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = WhitePageResource::class;
}
