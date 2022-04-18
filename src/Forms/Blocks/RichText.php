<?php

namespace Trov\Forms\Blocks;

use Filament\Forms\Components\Builder\Block;
use FilamentTipTapEditor\TipTapEditor;

class RichText
{
    public static function make(string $field = 'rich-text'): Block
    {
        return Block::make($field)
            ->schema([
                TipTapEditor::make('content')
                    ->required(),
            ]);
    }
}
