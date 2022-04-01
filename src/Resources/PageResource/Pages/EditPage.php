<?php

namespace Trov\Resources\PageResource\Pages;

use Trov\Resources\PageResource;
use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    use HasCustomEditActions;

    protected $listeners = [
        'refresh-page' => '$refresh'
    ];

    protected static string $resource = PageResource::class;
}
