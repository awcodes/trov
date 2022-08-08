<?php

namespace Trov\Filament\Resources\FaqResource\Pages;

use Filament\Resources\Pages\ListRecords;

class ListFaqs extends ListRecords
{
    public static function getResource(): string
    {
        return config('trov.resources.faqs');
    }

    protected function getTitle(): string
    {
        return 'FAQs';
    }
}
