<?php

namespace App\Resources\DiscoveryTopicResource\Pages;

use App\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;
use App\Resources\DiscoveryTopicResource;

class EditDiscoveryTopic extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = DiscoveryTopicResource::class;
}
