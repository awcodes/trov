<?php

namespace Trov\Forms\Components;

use Closure;
use TrovComponents\Filament\Panel;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use TrovComponents\Forms\Fields\VideoEmbed;
use FilamentCurator\Forms\Components\MediaPicker;

class Hero
{
    public static function make(): Panel
    {
        return Panel::make('Hero')
            ->schema([
                Toggle::make('hero.is_video')
                    ->label('Is Video')
                    ->reactive(),
                MediaPicker::make('hero.image')
                    ->label('Image')
                    ->hidden(fn (Closure $get): bool => $get('hero.is_video')),
                VideoEmbed::make('hero.video')
                    ->label('Embed Code')
                    ->visible(fn (Closure $get): bool => $get('hero.is_video'))
                    ->rows(3)
                    ->reactive(),
                Textarea::make('hero.cta')
                    ->label('Call to Action')
                    ->rows(3),
            ]);
    }
}
