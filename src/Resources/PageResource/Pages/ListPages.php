<?php

namespace Trov\Resources\PageResource\Pages;

use Trov\Models\Page;
use Trov\Resources\PageResource;
use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPages extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = PageResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->orderBy('front_page', 'desc')->orderBy('title', 'asc');
    }
}
