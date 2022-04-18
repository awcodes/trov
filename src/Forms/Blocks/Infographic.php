<?php

namespace Trov\Forms\Blocks;

use Illuminate\Support\HtmlString;
use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Builder\Block;

class Infographic
{
    public static function make(string $field = 'infographic'): Block
    {
        return Block::make($field)
            ->schema([
                MediaPicker::make('image')
                    ->label('Image'),
                Textarea::make('transcript')
                    ->label('Transcript'),
            ]);
    }
}
