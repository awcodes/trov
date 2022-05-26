<?php

namespace App\Forms\Trov\Blocks;

use App\Forms\Trov\Blocks\Code;
use App\Forms\Trov\Blocks\Image;
use App\Forms\Trov\Blocks\RichText;
use Filament\Forms\Components\Builder;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Builder\Block;
use FilamentCurator\Forms\Components\MediaPicker;

class Grid
{
    public static function make(): Block
    {
        return Block::make('grid')
            ->schema([
                Repeater::make('columns')
                    ->createItemButtonLabel('Add Column')
                    ->schema([
                        Builder::make('content')
                            ->createItemButtonLabel('Add Content')
                            ->blocks([
                                RichText::make('simple'),
                                Image::make(),
                                Code::make(),
                            ]),
                    ])
                    ->maxItems(4)
            ]);
    }
}
