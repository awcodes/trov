<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapEditor;

class Detail
{
    public static function make(): Block
    {
        return Block::make('detail')
            ->label('Detail')
            ->schema([
                TextInput::make('summary')
                    ->required(),
                TiptapEditor::make('content')
                    ->disableLabel()
                    ->profile('simple')
                    ->required(),
            ]);
    }
}
