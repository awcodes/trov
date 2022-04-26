<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Builder\Block;
use FilamentTiptapEditor\TiptapEditor;

class Grid
{
    public static function make(): Block
    {
        return Block::make('grid')
            ->schema([
                Repeater::make('columns')
                    ->createItemButtonLabel('Add Column')
                    ->schema([
                        MediaPicker::make('image'),
                        TiptapEditor::make('content')
                            ->label('Rich Text')
                            ->disableLabel()
                            ->profile('simple')
                            ->required(),
                    ])
                    ->maxItems(4)
            ]);
    }
}
