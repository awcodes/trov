<?php

namespace App\Filament\Resources\Trov;

use Filament\Forms;
use Filament\Tables;
use App\Models\Author;
use Livewire\Component;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Route;
use Filament\Forms\Components\Section;
use FilamentAddons\Admin\FixedSidebar;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\Trov\AuthorResource\Pages;
use App\Filament\Resources\Trov\AuthorResource\Pages\EditAuthor;
use App\Filament\Resources\Trov\AuthorResource\Pages\ListAuthors;
use App\Filament\Resources\Trov\AuthorResource\Pages\CreateAuthor;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $label = 'Author';

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return FixedSidebar::make()
            ->schema([
                Section::make('About')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $livewire) {
                                if ($livewire instanceof CreateAuthor) {
                                    return $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->unique(Author::class, 'slug', fn ($record) => $record),
                        TiptapEditor::make('bio')
                            ->profile('barebone')
                            ->columnSpan(['sm' => 2]),
                    ]),
                Section::make('Social')
                    ->schema([
                        Group::make()->schema([
                            TextInput::make('facebook_handle'),
                            TextInput::make('twitter_handle'),
                            TextInput::make('instagram_handle'),
                            TextInput::make('linkedin_handle'),
                            TextInput::make('youtube_handle'),
                            TextInput::make('pinterest_handle'),
                        ])->columns(2)->columnSpan(['sm' => 2])
                    ])
            ], [
                Section::make('Avatar')
                    ->schema([
                        FileUpload::make('avatar')
                            ->avatar()
                            ->directory('avatars')
                            ->maxSize(512)
                            ->columnSpan('full'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                ImageColumn::make('avatar_url')->rounded()->size(36),
            ])
            ->filters([
                //
            ])->defaultSort('name', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuthors::route('/'),
            'create' => CreateAuthor::route('/create'),
            'edit' => EditAuthor::route('/{record}/edit'),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        // $count = $record->posts->count();
        // if ($count === 0) {
        //     return true;
        // }

        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
