<?php

namespace App\Filament\Resources\Trov\PageResource\Pages;

use App\Filament\Resources\Trov\PageResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    public function getActions(): array
    {
        return [
            ButtonAction::make('create')->action('saveFormFromAction'),
        ];
    }

    public function saveFormFromAction(): void
    {
        $this->create();
    }
}