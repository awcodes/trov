<?php

namespace App\Filament\Resources\Trov\FaqResource\Pages;

use App\Filament\Resources\Trov\FaqResource;
use Filament\Resources\Pages\ListRecords;

class ListFaqs extends ListRecords
{
    protected static string $resource = FaqResource::class;

    protected function getTitle(): string
    {
        return 'FAQs';
    }
}
