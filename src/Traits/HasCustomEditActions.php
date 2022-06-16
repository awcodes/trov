<?php

namespace Trov\Traits;

use Illuminate\Support\Arr;
use FilamentAddons\Forms\Actions\PublicViewAction;
use Filament\Pages\Actions;

trait HasCustomEditActions
{
    public function getActions(): array
    {
        return [
            Actions\Action::make('save')->color('primary')->action('save'),
            PublicViewAction::make()->record($this->getRecord()),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
