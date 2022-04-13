<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Trov\Forms\Components\BlockHeading;
use Filament\Forms\Components\Builder\Block;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

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
                TinyEditor::make('content')
                    ->label('Rich Text')
                    ->disableLabel()
                    ->profile('custom')
                    ->showMenuBar()
                    ->required()
                    ->columnSpan(2),
            ])->columns(['sm' => 3]);
    }
}
