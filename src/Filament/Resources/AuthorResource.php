<?php

namespace Trov\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\CreateRecord;
use Trov\Filament\Resources\AuthorResource\Pages;

use FilamentAddons\Admin\FixedSidebar;

use FilamentTiptapEditor\TiptapEditor;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

use Trov\Models\Author;

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
                Forms\Components\Section::make('About')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $livewire) {
                                if ($livewire instanceof CreateRecord) {
                                    return $set('slug', Str::slug($state));
                                }
                            }),
                            Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(Author::class, 'slug', fn ($record) => $record),
                        TiptapEditor::make('bio')
                            ->profile('barebone')
                            ->columnSpan(['sm' => 2]),
                    ]),
                    Forms\Components\Section::make('Social')
                    ->schema([
                        Forms\Components\Group::make()->schema([
                            Forms\Components\TextInput::make('facebook_handle'),
                            Forms\Components\TextInput::make('twitter_handle'),
                            Forms\Components\TextInput::make('instagram_handle'),
                            Forms\Components\TextInput::make('linkedin_handle'),
                            Forms\Components\TextInput::make('youtube_handle'),
                            Forms\Components\TextInput::make('pinterest_handle'),
                        ])->columns(2)->columnSpan(['sm' => 2])
                    ])
            ], [
                Forms\Components\Section::make('Avatar')
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
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
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\ImageColumn::make('avatar_url')->rounded()->size(36),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
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
