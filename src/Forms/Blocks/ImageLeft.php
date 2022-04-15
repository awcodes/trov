<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Trov\Forms\Components\BlockHeading;
use Filament\Forms\Components\Builder\Block;
use FilamentTipTapEditor\TipTapEditor;

class ImageLeft
{
    public static function make(string $field = 'image-left'): Block
    {
        return Block::make($field)
            ->label('Image with Text on Right')
            ->schema([
                BlockHeading::make('Image on Left Block')
                    ->columnSpan('full'),
                MediaPicker::make('image')
                    ->label('Image')
                    ->columnSpan(1),
                TipTapEditor::make('content')
                    ->label('Rich Text')
                    ->disableLabel()
                    ->profile('simple')
                    ->required()
                    ->columnSpan(2),
            ])->columns(['sm' => 3]);
    }
}
