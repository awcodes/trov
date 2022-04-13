<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Textarea;
use Trov\Forms\Components\BlockHeading;
use Filament\Forms\Components\Builder\Block;

class Hero
{
    public static function make(string $field = 'hero'): Block
    {
        return Block::make($field)
            ->schema([
                BlockHeading::make('Hero Block'),
                MediaPicker::make('image')
                    ->label('Image'),
                Textarea::make('content')
                    ->label('Call to Action')
                    ->rows(2),
            ]);
    }
}
