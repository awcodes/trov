<?php

namespace App\Filament\Resources\Trov\PageResource\Pages;

use App\Filament\Resources\Trov\PageResource;
use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;
use Trov\Traits\HasSoftDeletes;

class EditPage extends EditRecord
{
    use HasCustomEditActions;

    protected $listeners = [
        'refresh-page' => '$refresh'
    ];

    protected static string $resource = PageResource::class;
}
