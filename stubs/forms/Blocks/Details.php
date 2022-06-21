<?php

namespace App\Forms\Trov\Blocks;

use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Builder\Block;

class Details
{
    public static function make(): Block
    {
        return Block::make('details')
            ->label('Details')
            ->schema([
                TextInput::make('summary')
                    ->required(),
                TiptapEditor::make('content')->profile('simple')
                    ->required(),
            ]);
    }
}
