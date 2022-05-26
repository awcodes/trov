<?php

namespace App\Filament\Resources\Trov\DiscoveryArticleResource\Pages;

use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Trov\DiscoveryArticleResource;

class EditDiscoveryArticle extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = DiscoveryArticleResource::class;
}
