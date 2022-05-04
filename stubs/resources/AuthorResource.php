<?php

namespace App\Filament\Resources\Trov;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use App\Models\Author;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Route;
use Filament\Forms\Components\Section;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\Trov\AuthorResource\Pages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use TrovComponents\Filament\FixedSidebar;
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
                Card::make()
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
                Card::make()
                    ->schema([
                        FileUpload::make('avatar')
                            ->directory('avatars')
                            ->image()
                            ->imagePreviewHeight('250')
                            ->maxFiles(1)
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
                ImageColumn::make('avatar')->rounded()->size(36),
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
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
