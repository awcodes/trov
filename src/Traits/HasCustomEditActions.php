<?php

namespace Trov\Traits;

use Filament\Pages\Actions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use FilamentAddons\Forms\Actions\PublicViewAction;

trait HasCustomEditActions
{
    public function getActions(): array
    {
        return [
            Actions\Action::make('save')->color('primary')->action('save'),
            PublicViewAction::make()->record($this->record),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
