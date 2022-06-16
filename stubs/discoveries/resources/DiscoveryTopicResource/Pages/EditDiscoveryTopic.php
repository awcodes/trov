<?php

namespace App\Filament\Resources\Trov\DiscoveryTopicResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Trov\DiscoveryTopicResource;
use Trov\Traits\HasCustomEditActions;

class EditDiscoveryTopic extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = DiscoveryTopicResource::class;
}
