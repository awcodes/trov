<?php

namespace Trov\Resources\DiscoveryTopicResource\Pages;

use Trov\Models\DiscoveryTopic;
use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;
use Trov\Resources\DiscoveryTopicResource;

class ListDiscoveryTopics extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = DiscoveryTopicResource::class;
}
