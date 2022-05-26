<?php

namespace App\Filament\Resources\Trov\DiscoveryTopicResource\Pages;

use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Trov\DiscoveryTopicResource;

class EditDiscoveryTopic extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = DiscoveryTopicResource::class;
}
