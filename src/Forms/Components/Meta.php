<?php

namespace Trov\Forms\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use FilamentAddons\Forms\Components\FieldGroup;
use FilamentCurator\Forms\Components\MediaPicker;

class Meta
{
    public static function make(): Section
    {
        return Section::make('SEO')
            ->collapsible()
            ->schema([
                FieldGroup::make('meta')
                    ->relationship('meta')
                    ->saveRelationshipsUsing(function ($component, $state) {
                        $record = $component->getCachedExistingRecord();
                        $state['og_image'] = isset($state['og_image']['id']) ? $state['og_image']['id'] : null;
                        if ($record) {
                            $record->update($state);

                            return;
                        }

                        $component->getRelationship()->create($state);
                    })
                    ->columns(['md' => 2])
                    ->schema([
                        Group::make([
                            TextInput::make('title')
                                ->label('Title')
                                ->helperText(function (?string $state): string {
                                    return Str::of(strlen($state))
                                        ->append(' / ')
                                        ->append(60 . ' ')
                                        ->append(str('characters')->lower())
                                        ->value();
                                })
                                ->required(),
                            Textarea::make('description')
                                ->label('Description')
                                ->rows(3)
                                ->helperText(function (?string $state): string {
                                    return Str::of(strlen($state))
                                        ->append(' / ')
                                        ->append(160 . ' ')
                                        ->append(str('characters')->lower())
                                        ->value();
                                })
                                ->reactive()
                                ->required(),
                            Toggle::make('indexable')
                                ->label('Indexable'),
                        ]),
                        MediaPicker::make('og_image')
                            ->label('OG Image')
                            ->helperText('Leave empty to use default. This will also be used on any resources that utilize a featured image.')
                    ]),
            ]);
    }
}
