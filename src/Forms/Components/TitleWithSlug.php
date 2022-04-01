<?php

namespace Trov\Forms\Components;

use Closure;
use Illuminate\Support\Str;
use Trov\Forms\Fields\SlugInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\CreateRecord;

class TitleWithSlug
{
    public static function make(string|null $title = 'title', string|null $slug = 'slug'): Group
    {
        return Group::make()
            ->schema([
                TextInput::make($title)
                    ->required()
                    ->reactive()
                    ->disableLabel()
                    ->placeholder(fn () => Str::of($title)->title())
                    ->extraInputAttributes(['class' => 'text-2xl'])
                    ->afterStateUpdated(function ($state, Closure $set, $livewire) {
                        if ($livewire instanceof CreateRecord) {
                            return $set('slug', Str::slug($state));
                        }
                    }),
                SlugInput::make($slug)
                    ->mode(fn ($livewire) => $livewire instanceof EditRecord ? 'edit' : 'create')
                    ->disableLabel()
                    ->required()
                    ->unique(ignorable: fn ($record) => $record),
            ]);
    }
}
