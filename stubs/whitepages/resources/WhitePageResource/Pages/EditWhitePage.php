<?php

namespace App\Filament\Resources\Trov\WhitePageResource\Pages;

use App\Filament\Resources\Trov\WhitePageResource;
use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditWhitePage extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = WhitePageResource::class;
}
