<?php

namespace App\Resources\FaqResource\Pages;

use App\Models\Faq;
use App\Resources\FaqResource;
use App\Traits\HasCustomTableActions;
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
