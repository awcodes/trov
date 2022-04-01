<?php

namespace Trov\Resources\DiscoveryTopicResource\Pages;

use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;
use Trov\Resources\DiscoveryTopicResource;

class EditDiscoveryTopic extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = DiscoveryTopicResource::class;
}
