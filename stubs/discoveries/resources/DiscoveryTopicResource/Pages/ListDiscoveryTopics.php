<?php

namespace App\Filament\Resources\Trov\DiscoveryTopicResource\Pages;

use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Trov\DiscoveryTopicResource;

class ListDiscoveryTopics extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = DiscoveryTopicResource::class;
}
