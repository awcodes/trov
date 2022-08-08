<?php

namespace Trov\Filament\Resources\FaqResource\Pages;

use Trov\Traits\HasCustomEditActions;
use Trov\Filament\Resources\FaqResource;
use Filament\Resources\Pages\EditRecord;

class EditFaq extends EditRecord
{
    use HasCustomEditActions;

    public static function getResource(): string
    {
        return config('trov.resources.faqs');
    }
}
