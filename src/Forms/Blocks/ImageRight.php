<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Builder\Block;
use FilamentTipTapEditor\TipTapEditor;

class ImageRight
{
    public static function make(string $field = 'image-right'): Block
    {
        return Block::make($field)
            ->label('Image with Text on Left')
            ->schema([
                TipTapEditor::make('content')
                    ->label('Rich Text')
                    ->disableLabel()
                    ->profile('simple')
                    ->required()
                    ->columnSpan(2),
                MediaPicker::make('image')
                    ->label('Image')
                    ->columnSpan(1),
            ])->columns(['sm' => 3]);
    }
}
