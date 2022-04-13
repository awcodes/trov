<?php

namespace Trov\Forms\Components;

use Filament\Forms\Components\View;

class Separator
{
    public static function make(): View
    {
        return View::make('trov::components.separator');
    }
}
