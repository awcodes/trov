<?php

namespace Trov\Filament\Resources\PageResource\Pages;

use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    public static function getResource(): string
    {
        return config('trov.resources.pages');
    }
}
