<?php

namespace App\Forms\Trov\Blocks;

use App\Forms\Trov\Blocks\Details;
use App\Forms\Trov\Blocks\RichText;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Builder\Block;

class Tabs
{
    public static function make(): Block
    {
        return Block::make('tabs')
            ->schema([
                Repeater::make('items')
                    ->disableLabel()
                    ->createItemButtonLabel('Add Tab')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        Builder::make('content')
                            ->createItemButtonLabel('Add Content')
                            ->blocks([
                                RichText::make('simple'),
                                Details::make(),
                            ])
                    ])
            ]);
    }
}
