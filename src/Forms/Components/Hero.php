<?php

namespace Trov\Forms\Components;

use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Pages\EditRecord;
use FilamentAddons\Forms\Components\OEmbed;
use FilamentCurator\Forms\Components\MediaPicker;

class Hero
{
    public static function make(): Section
    {
        return Section::make('Hero')
            ->schema([
                Radio::make('hero.type')
                    ->inline()
                    ->default('image')
                    ->options([
                        'image' => 'Image',
                        'oembed' => 'oEmbed',
                    ])
                    ->reactive(),
                MediaPicker::make('hero.image')
                    ->label('Image')
                    ->visible(fn (Closure $get): bool => $get('hero.type') == 'image' ?: false),
                OEmbed::make('hero.oembed')
                    ->visible(fn (Closure $get): bool => $get('hero.type') == 'oembed' ?: false),
                Textarea::make('hero.cta')
                    ->label('Call to Action')
                    ->rows(3),
            ]);
    }
}
