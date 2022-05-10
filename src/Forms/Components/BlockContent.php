<?php

namespace Trov\Forms\Components;

use Closure;
use Trov\Forms\Blocks\Code;
use Trov\Forms\Blocks\Grid;
use Trov\Forms\Blocks\Hero;
use Trov\Forms\Blocks\Image;
use Trov\Forms\Blocks\Heading;
use Trov\Forms\Blocks\RichText;
use Trov\Forms\Blocks\ImageLeft;
use Trov\Forms\Blocks\ImageRight;
use Trov\Forms\Blocks\Infographic;
use Filament\Forms\Components\Builder;
use Trov\Forms\Blocks\Detail;

class BlockContent
{
    public static function make(string $field): Builder
    {
        return Builder::make($field)
            ->createItemButtonLabel('Add Block')
            ->blocks([
                RichText::make('simple'),
                Grid::make(),
                Hero::make(),
                Image::make(),
                ImageLeft::make(),
                ImageRight::make(),
                Detail::make(),
                Infographic::make(),
                Code::make(),
            ]);
    }
}
