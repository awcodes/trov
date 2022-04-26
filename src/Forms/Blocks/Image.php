<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Builder\Block;

class Image
{
    public static function make(): Block
    {
        return Block::make('Image')
            ->schema([
                MediaPicker::make('image')
                    ->label('Image'),
            ]);
    }
}
