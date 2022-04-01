<?php

namespace App\Resources\PageResource\Pages;

use App\Models\Page;
use App\Resources\PageResource;
use App\Traits\HasCustomTableActions;
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
