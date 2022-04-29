<?php

namespace Trov\Traits;

trait HasCustomCreateActions
{
    protected function getActions(): array
    {
        return array_merge(
            [$this->getCreateFormAction()],
            static::canCreateAnother() ? [$this->getCreateAndCreateAnotherFormAction()] : [],
            [$this->getCancelFormAction()],
        );
    }
}
