<?php

namespace Trov\Resources\WhitePageResource\Pages;

use Trov\Resources\WhitePageResource;
use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditWhitePage extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = WhitePageResource::class;
}
