<?php

namespace Trov\Forms\Components;

use Closure;
use Trov\Forms\Blocks\Grid;
use Trov\Forms\Blocks\Hero;
use Trov\Forms\Blocks\Image;
use Trov\Forms\Blocks\Heading;
use Trov\Forms\Blocks\RichText;
use Trov\Forms\Blocks\ImageLeft;
use Trov\Forms\Blocks\ImageRight;
use Trov\Forms\Blocks\Infographic;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Repeater;

class BlockContent
{
    public static function make(string $field): Repeater
    {
        return Repeater::make($field)
            ->label('Sections')
            ->defaultItems(0)
            ->createItemButtonLabel('Add Section')
            ->schema([
                Toggle::make('full_width')
                    ->default(false)
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        if ($state === false) {
                            return $set('bg_color', '');
                        }
                    }),
                Select::make('bg_color')
                    ->label('Background Color')
                    ->hidden(fn (Closure $get) => $get('full_width') === false)
                    ->options([
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                        'tertiary' => 'Tertiary',
                        'accent' => 'Accent',
                        'gray' => 'Gray',
                    ]),
                Builder::make('blocks')
                    ->label('Blocks')
                    ->createItemButtonLabel('Add Block')
                    ->showBlockLabels()
                    ->blocks([
                        RichText::make(),
                        Grid::make(),
                        Hero::make(),
                        Image::make(),
                        ImageLeft::make(),
                        ImageRight::make(),
                        Infographic::make(),
                    ]),
            ]);
    }
}
