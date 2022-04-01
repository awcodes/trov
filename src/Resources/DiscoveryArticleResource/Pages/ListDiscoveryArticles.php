<?php

namespace Trov\Resources\DiscoveryArticleResource\Pages;

use Trov\Models\DiscoveryArticle;
use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;
use Trov\Resources\DiscoveryArticleResource;

class ListDiscoveryArticles extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = DiscoveryArticleResource::class;
}
