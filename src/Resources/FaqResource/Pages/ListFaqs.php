<?php

namespace Trov\Resources\FaqResource\Pages;

use Trov\Models\Faq;
use Trov\Resources\FaqResource;
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
