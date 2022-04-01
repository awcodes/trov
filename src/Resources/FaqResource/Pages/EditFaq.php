<?php

namespace Trov\Resources\FaqResource\Pages;

use Trov\Resources\FaqResource;
use Trov\Traits\HasCustomEditActions;
use Filament\Resources\Pages\EditRecord;

class EditFaq extends EditRecord
{
    use HasCustomEditActions;

    protected static string $resource = FaqResource::class;
}
