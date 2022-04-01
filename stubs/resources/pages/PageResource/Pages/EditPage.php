<?php

namespace App\Resources\PageResource\Pages;

use App\Resources\PageResource;
use App\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    use HasCustomEditActions;

    protected $listeners = [
        'refresh-page' => '$refresh'
    ];

    protected static string $resource = PageResource::class;
}
