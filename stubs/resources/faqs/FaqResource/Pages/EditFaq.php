<?php

namespace App\Resources\FaqResource\Pages;

use App\Resources\FaqResource;
use App\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditFaq extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = FaqResource::class;
}
