<?php

namespace App\Filament\Resources\Trov\DiscoveryArticleResource\Pages;

use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Trov\DiscoveryArticleResource;

class ListDiscoveryArticles extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = DiscoveryArticleResource::class;
}
