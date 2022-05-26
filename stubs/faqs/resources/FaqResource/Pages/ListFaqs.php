<?php

namespace App\Filament\Resources\Trov\FaqResource\Pages;

use App\Models\Faq;
use App\Filament\Resources\Trov\FaqResource;
use Trov\Traits\HasCustomTableActions;
use Filament\Resources\Pages\ListRecords;

class ListFaqs extends ListRecords
{
    use HasCustomTableActions;

    protected static string $resource = FaqResource::class;

    protected function getTitle(): string
    {
        return 'FAQs';
    }
}
