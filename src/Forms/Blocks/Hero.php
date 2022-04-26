<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Builder\Block;

class Hero
{
    public static function make(): Block
    {
        return Block::make('hero')
            ->schema([
                MediaPicker::make('image')
                    ->label('Image'),
                Textarea::make('content')
                    ->label('Call to Action')
                    ->rows(2),
            ]);
    }
}
