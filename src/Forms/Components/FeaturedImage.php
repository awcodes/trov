<?php

namespace Trov\Forms\Components;

use Trov\Forms\Fields\MediaPicker;
use Filament\Forms\Components\Section;

class FeaturedImage
{
    public static function make(): Section
    {
        return Section::make('Featured Image')
            ->schema([
                MediaPicker::make('featured_image')
                    ->disableLabel(),
            ]);
    }
}
