<?php

namespace App\Forms\Trov\Components;

use Closure;
use App\Forms\Trov\Blocks\Details;
use App\Forms\Trov\Blocks\RichText;
use App\Forms\Trov\Blocks\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Repeater;

class PageBuilder
{
    public static function make(string $field): Repeater
    {
        return Repeater::make($field)
            ->label('Sections')
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
                        'light-gray' => 'Light Gray',
                        'white' => 'White',
                    ]),
                Builder::make('blocks')
                    ->createItemButtonLabel('Add Block')
                    ->blocks([
                        RichText::make(),
                        Details::make(),
                        Tabs::make(),
                    ]),
            ]);
    }
}
