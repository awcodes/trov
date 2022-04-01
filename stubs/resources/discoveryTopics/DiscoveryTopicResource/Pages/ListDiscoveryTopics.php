<?php

namespace App\Resources\DiscoveryTopicResource\Pages;

use App\Models\DiscoveryTopic;
use App\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;
use App\Resources\DiscoveryTopicResource;

class ListDiscoveryTopics extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = DiscoveryTopicResource::class;
}
