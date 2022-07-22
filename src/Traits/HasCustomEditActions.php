<?php

namespace Trov\Traits;

use Filament\Pages\Actions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use FilamentAddons\Forms\Actions\PreviewAction;

trait HasCustomEditActions
{
    public function getActions(): array
    {
        return [
            Actions\Action::make('save')->color('primary')->action('save'),
            PreviewAction::make()->record($this->record),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
