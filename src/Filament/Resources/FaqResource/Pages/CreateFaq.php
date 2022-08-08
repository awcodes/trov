<?php

namespace Trov\Filament\Resources\FaqResource\Pages;

use Filament\Resources\Pages\CreateRecord;

class CreateFaq extends CreateRecord
{
    public static function getResource(): string
    {
        return config('trov.resources.faqs');
    }
}
