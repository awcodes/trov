<?php

namespace App\Filament\Resources\Trov\DiscoveryArticleResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Trov\DiscoveryArticleResource;
use Trov\Traits\HasCustomEditActions;

class EditDiscoveryArticle extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = DiscoveryArticleResource::class;
}
