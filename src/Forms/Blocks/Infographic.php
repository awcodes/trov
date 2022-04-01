<?php

namespace Trov\Forms\Blocks;

use Illuminate\Support\HtmlString;
use Trov\Forms\Fields\MediaPicker;
use Filament\Forms\Components\Textarea;
use Trov\Forms\Components\BlockHeading;
use Filament\Forms\Components\Builder\Block;

class Infographic
{
    public static function make(string $field = 'infographic'): Block
    {
        return Block::make($field)
            ->schema([
                BlockHeading::make('Infographic Block'),
                MediaPicker::make('image')
                    ->label('Image'),
                Textarea::make('transcript')
                    ->label('Transcript'),
            ]);
    }
}
