<?php

namespace Trov\Traits;

use Filament\Pages\Actions\Action;

trait HasCustomCreateActions
{
    protected function getActions(): array
    {
        return array_merge(
            [Action::make('create')
                ->label(__('filament::resources/pages/create-record.form.actions.create.label'))
                ->action('create')
                ->keyBindings(['mod+s'])],
            static::canCreateAnother() ? [$this->getCreateAndCreateAnotherFormAction()] : [],
            [$this->getCancelFormAction()],
        );
    }
}
