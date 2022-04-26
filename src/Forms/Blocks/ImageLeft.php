<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Builder\Block;
use FilamentTiptapEditor\TiptapEditor;

class ImageLeft
{
    public static function make(): Block
    {
        return Block::make('image-left')
            ->label('Image with Text on Right')
            ->schema([
                MediaPicker::make('image')
                    ->label('Image')
                    ->columnSpan(1),
                TiptapEditor::make('content')
                    ->label('Rich Text')
                    ->disableLabel()
                    ->profile('simple')
                    ->required()
                    ->columnSpan(2),
            ])->columns(['sm' => 3]);
    }
}
