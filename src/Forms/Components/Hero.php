<?php

namespace Trov\Forms\Components;

use Closure;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use FilamentAddons\Forms\Fields\VideoEmbed;
use FilamentAddons\Forms\Components\VimeoEmbed;
use FilamentAddons\Forms\Components\YouTubeEmbed;
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
                        'youtube' => 'YouTube',
                        'vimeo' => 'Vimeo'
                    ])
                    ->reactive(),
                MediaPicker::make('hero.image')
                    ->label('Image')
                    ->visible(fn (Closure $get): bool => $get('hero.type') == 'image' ?: false),
                YouTubeEmbed::make('hero.youtube')
                    ->label('YouTube Embed')
                    ->visible(fn (Closure $get): bool => $get('hero.type') == 'youtube' ?: false),
                VimeoEmbed::make('hero.vimeo')
                    ->label('YouTube Embed')
                    ->visible(fn (Closure $get): bool => $get('hero.type') == 'vimeo' ?: false),
                Textarea::make('hero.cta')
                    ->label('Call to Action')
                    ->rows(3),
            ]);
    }
}
