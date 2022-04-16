<?php

namespace Trov\Forms\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use TrovComponents\Filament\Panel;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use FilamentCurator\Forms\Components\MediaPicker;

class Meta
{
    public static function make(array $only = ['title', 'description', 'indexable', 'og_image']): Panel
    {
        return Panel::make('SEO')
            ->collapsible()
            ->schema([
                Group::make(
                    Arr::only([
                        'title' => TextInput::make('title')
                            ->label('Title')
                            ->helperText(function (?string $state): string {
                                return Str::of(strlen($state))
                                    ->append(' / ')
                                    ->append(60 . ' ')
                                    ->append(str('characters')->lower())
                                    ->value();
                            })
                            ->required(),
                        'description' => Textarea::make('description')
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
                        'indexable' => Toggle::make('indexable')
                            ->label('Indexable'),
                        'og_image' => MediaPicker::make('og_image')->label('OG Image')->helperText('Leave empty to use default. This will also be used on any resources that utilizes a featured image.'),
                    ], $only)
                )
                    ->afterStateHydrated(function (Group $component, ?Model $record, $state) use ($only): void {
                        $component->getChildComponentContainer()->fill(
                            $record && $record->meta ? $record->meta->only($only) : $state
                        );
                    })
                    ->statePath('meta')
                    ->dehydrated(false)
                    ->saveRelationshipsUsing(function (Model $record, array $state) use ($only): void {
                        $method = $record->meta ? 'update' : 'create';
                        $record->meta()->{$method}(
                            collect($state)->only($only)->map(function ($value) {
                                if ($value === false) {
                                    return false;
                                }

                                if (is_array($value)) {
                                    return $value['id'];
                                }

                                return $value ?: null;
                            })->all()
                        );
                    })
            ]);
    }
}
