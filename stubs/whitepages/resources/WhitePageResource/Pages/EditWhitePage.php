<?php

namespace App\Filament\Resources\Trov\WhitePageResource\Pages;

use App\Filament\Resources\Trov\WhitePageResource;
use Filament\Resources\Pages\EditRecord;
use Trov\Traits\HasCustomEditActions;

class EditWhitePage extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = WhitePageResource::class;
}
