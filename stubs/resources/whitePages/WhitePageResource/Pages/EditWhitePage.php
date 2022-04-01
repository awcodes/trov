<?php

namespace App\Resources\WhitePageResource\Pages;

use App\Resources\WhitePageResource;
use App\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditWhitePage extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = WhitePageResource::class;
}
