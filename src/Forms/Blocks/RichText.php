<?php

namespace Trov\Forms\Blocks;

use Trov\Forms\Components\BlockHeading;
use Filament\Forms\Components\Builder\Block;
use FilamentTipTapEditor\TipTapEditor;

class RichText
{
    public static function make(string $field = 'rich-text'): Block
    {
        return Block::make($field)
            ->schema([
                BlockHeading::make('Rich Text Block'),
                TipTapEditor::make('content')
                    ->required(),
            ]);
    }
}
