<?php

namespace Trov\Forms\Components;

use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

class BlockHeading
{
    public static function make(string $text): Placeholder
    {
        return Placeholder::make('block_heading')
            ->disableLabel()
            ->extraAttributes(['class' => 'font-bold'])
            ->content(new HtmlString('<h3 class="">' . $text . '</h3>'));
    }
}
