<?php

namespace Trov\Traits;

use Filament\Pages\Actions\ButtonAction;
use TrovComponents\Filament\MultiActionButton;

trait HasCustomEditActions
{
    public function getActions(): array
    {
        parent::getActions();

        return [MultiActionButton::make('blah')->actions(array_merge([
            ButtonAction::make('save')->action('saveFormFromAction'),
            ButtonAction::make('view')->hidden($this->record->deleted_at !== null)->color('secondary')->url($this->record->getPublicUrl())->openUrlInNewTab(),
        ], $this->getDestroyActions()))];
    }

    public function saveFormFromAction(): void
    {
        $this->save();
    }

    public function restore(): void
    {
        abort_unless(static::getResource()::canDelete($this->record), 403);

        $this->callHook('beforeDelete');

        $this->record->restore();

        $this->callHook('afterDelete');

        $this->notify(
            'success',
            'Successfully restored from trash.',
        );

        $this->emit('refresh-page');
    }

    public function destroy(): void
    {
        abort_unless(static::getResource()::canDelete($this->record), 403);

        $this->callHook('beforeDelete');

        $this->record->forceDelete();

        $this->callHook('afterDelete');

        $this->notify(
            'success',
            static::getResource()::getLabel() . ' permenantly deleted.',
            isAfterRedirect: true
        );

        $this->redirect($this->getDeleteRedirectUrl());
    }

    public function getDestroyActions()
    {
        if ($this->record->deleted_at) {
            return [
                ButtonAction::make('restore')
                    ->label('Restore')
                    ->requiresConfirmation()
                    ->modalHeading('Restore: ' . static::getResource()::getLabel())
                    ->modalSubheading('Are you sure you would like to do this?')
                    ->modalButton('Restore')
                    ->action('restore')
                    ->color('warning'),
                ButtonAction::make('destroy')
                    ->label('Permenently Delete')
                    ->requiresConfirmation()
                    ->modalHeading('Permenantly Delete: ' . static::getResource()::getLabel())
                    ->modalSubheading('Are you sure you would like to do this?')
                    ->modalButton('Destroy')
                    ->action('destroy')
                    ->color('danger')
            ];
        }

        return [parent::getDeleteAction()];
    }
}
