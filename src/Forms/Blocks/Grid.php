<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Builder\Block;
use FilamentTipTapEditor\TipTapEditor;

class Grid
{
    public static function make(string $field = 'grid'): Block
    {
        return Block::make($field)
            ->schema([
                Repeater::make('columns')
                    ->createItemButtonLabel('Add Column')
                    ->schema([
                        MediaPicker::make('image'),
                        TipTapEditor::make('content')
                            ->label('Rich Text')
                            ->disableLabel()
                            ->profile('simple')
                            ->required(),
                    ])
                    ->maxItems(4)
            ]);
    }
}
