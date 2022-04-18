<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Builder\Block;

class Image
{
    public static function make(string $field = 'image'): Block
    {
        return Block::make($field)
            ->schema([
                MediaPicker::make('image')
                    ->label('Image'),
            ]);
    }
}
