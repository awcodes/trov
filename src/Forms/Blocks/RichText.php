<?php

namespace Trov\Forms\Blocks;

use Filament\Forms\Components\Builder\Block;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Trov\Forms\Components\BlockHeading;

class RichText
{
    public static function make(string $field = 'rich-text'): Block
    {
        return Block::make($field)
            ->schema([
                BlockHeading::make('Rich Text Block'),
                TinyEditor::make('content')
                    ->label('Rich Text')
                    ->disableLabel()
                    ->profile('custom')
                    ->showMenuBar()
                    ->required(),
            ]);
    }
}
