<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Builder\Block;
use FilamentTiptapEditor\TiptapEditor;

class ImageRight
{
    public static function make(): Block
    {
        return Block::make('image-right')
            ->label('Image with Text on Left')
            ->schema([
                TiptapEditor::make('content')
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
