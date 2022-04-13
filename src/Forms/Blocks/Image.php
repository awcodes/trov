<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Trov\Forms\Components\BlockHeading;
use Filament\Forms\Components\Builder\Block;

class Image
{
    public static function make(string $field = 'image'): Block
    {
        return Block::make($field)
            ->schema([
                BlockHeading::make('Image Block'),
                MediaPicker::make('image')
                    ->label('Image'),
            ]);
    }
}
