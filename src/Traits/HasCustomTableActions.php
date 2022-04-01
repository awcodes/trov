<?php

namespace Trov\Traits;

use Filament\Tables\Actions\IconButtonAction;

trait HasCustomTableActions
{
    protected function getTableActions(): array
    {
        parent::getTableActions();

        return [
            IconButtonAction::make('preview')
                ->label('Preview Page')
                ->icon('heroicon-s-eye')
                ->url(fn ($record): string => $record->getPublicUrl())
                ->openUrlInNewTab(),
            IconButtonAction::make('edit')
                ->label('Edit post')
                ->url(fn ($record): string => route('filament.resources.pages.edit', $record))
                ->icon('heroicon-o-pencil')
        ];
    }
}
