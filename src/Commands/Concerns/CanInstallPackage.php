<?php

namespace Trov\Commands\Concerns;

use Illuminate\Support\Facades\Schema;

trait CanInstallPackage
{
    protected function CheckIfAlreadyInstalled(): bool
    {
        $count = $this->getTables()
            ->filter(function ($table) {
                return Schema::hasTable($table);
            })
            ->count();
        if ($count !== 0) {
            return true;
        }

        return false;
    }
}
