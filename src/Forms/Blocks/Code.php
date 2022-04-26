<?php

namespace Trov\Forms\Blocks;

use Filament\Forms\Components\Builder\Block;
use SebastiaanKloos\FilamentCodeEditor\Components\CodeEditor;

class Code
{
    public static function make(): Block
    {
        return Block::make('code')
            ->schema([
                CodeEditor::make('content')
                    ->required(),
            ]);
    }
}
