<?php

namespace Trov\Forms\Blocks;

use Filament\Forms\Components\Builder\Block;
use SebastiaanKloos\FilamentCodeEditor\Components\CodeEditor;

class Code
{
    public static function make(string $field = 'code'): Block
    {
        return Block::make($field)
            ->schema([
                CodeEditor::make('content')
                    ->required(),
            ]);
    }
}
