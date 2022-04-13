<?php

namespace Trov\Forms\Blocks;

use FilamentCurator\Forms\Components\MediaPicker;
use Trov\Forms\Components\BlockHeading;
use Filament\Forms\Components\Builder\Block;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ImageRight
{
    public static function make(string $field = 'image-right'): Block
    {
        return Block::make($field)
            ->label('Image with Text on Left')
            ->schema([
                BlockHeading::make('Image on Right Block')
                    ->columnSpan('full'),
                TinyEditor::make('content')
                    ->label('Rich Text')
                    ->disableLabel()
                    ->profile('custom')
                    ->showMenuBar()
                    ->required()
                    ->columnSpan(2),
                MediaPicker::make('image')
                    ->label('Image')
                    ->columnSpan(1),
            ])->columns(['sm' => 3]);
    }
}
