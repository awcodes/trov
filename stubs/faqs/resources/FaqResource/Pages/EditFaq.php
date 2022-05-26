<?php

namespace App\Filament\Resources\Trov\FaqResource\Pages;

use App\Filament\Resources\Trov\FaqResource;
use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditFaq extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = FaqResource::class;
}
