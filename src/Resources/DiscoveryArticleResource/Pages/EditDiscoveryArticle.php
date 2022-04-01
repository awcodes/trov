<?php

namespace Trov\Resources\DiscoveryArticleResource\Pages;

use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;
use Trov\Resources\DiscoveryArticleResource;

class EditDiscoveryArticle extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = DiscoveryArticleResource::class;
}
