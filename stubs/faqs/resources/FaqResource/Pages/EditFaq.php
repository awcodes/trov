<?php

namespace App\Filament\Resources\Trov\FaqResource\Pages;

use App\Filament\Resources\Trov\FaqResource;
use Filament\Resources\Pages\EditRecord;
use Trov\Traits\HasCustomEditActions;

class EditFaq extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = FaqResource::class;
}
