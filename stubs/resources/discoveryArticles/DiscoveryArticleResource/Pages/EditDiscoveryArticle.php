<?php

namespace App\Resources\DiscoveryArticleResource\Pages;

use App\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;
use App\Resources\DiscoveryArticleResource;

class EditDiscoveryArticle extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = DiscoveryArticleResource::class;
}
