<?php

namespace Trov\Forms\Blocks;

use FilamentBardEditor\BardEditor;
use Trov\Forms\Components\BlockHeading;
use Filament\Forms\Components\Builder\Block;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class RichText
{
    public static function make(string $field = 'rich-text'): Block
    {
        return Block::make($field)
            ->schema([
                BlockHeading::make('Rich Text Block'),
                BardEditor::make('content')
                    ->excludes(['blockquote', 'subscript'])
                    ->required(),
            ]);
    }
}
