<?php

namespace Trov\Traits;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;

trait HasCustomCreateActions
{
    protected function getActions(): array
    {
        return $this->getFormActions();
    }
}
