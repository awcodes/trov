<?php

namespace App\Resources\MediaResource\Pages;

use App\Resources\MediaResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;

class EditMedia extends EditRecord
{
    protected static string $resource = MediaResource::class;

    public function getActions(): array
    {
        return array_merge(parent::getActions(), [
            ButtonAction::make('view')->color('gray')->url($this->record->url)->openUrlInNewTab(),
            ButtonAction::make('save')->action('saveFormFromAction'),
        ]);
    }

    public function saveFormFromAction(): void
    {
        $this->save();
    }
}
