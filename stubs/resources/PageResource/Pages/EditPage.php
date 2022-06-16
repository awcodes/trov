<?php

namespace App\Filament\Resources\Trov\PageResource\Pages;

use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Trov\PageResource;

class EditPage extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = PageResource::class;
}
