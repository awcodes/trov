<?php

namespace Trov\Filament\Resources;

use Filament\Forms;
use Filament\Tables;

use Trov\Models\Post;
use Filament\Resources\Form;

use Trov\Forms as TrovForms;
use Filament\Resources\Table;
use Filament\Resources\Resource;

use FilamentTiptapEditor\TiptapEditor;

use FilamentAddons\Enums\Status;
use FilamentAddons\Forms as AddonForms;
use FilamentAddons\Tables as AddonTables;

use Illuminate\Database\Eloquent\Builder;
use Trov\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $label = 'Post';

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationLabel = "Blog Posts";

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $recordRouteKeyName = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            AddonForms\Components\TitleWithSlug::make('title', 'slug', '/posts/')->columnSpan('full'),
            Forms\Components\Section::make('Details')
                ->collapsible()
                ->collapsed(fn ($context) => $context == 'edit')
                ->columns(['md' => 2])
                ->schema([
                    Forms\Components\Group::make([
                        Forms\Components\Select::make('status')
                            ->default('Draft')
                            ->options(Status::class)
                            ->required()
                            ->columnSpan(2),
                        AddonForms\Fields\DateInput::make('published_at')
                            ->label('Publish Date')
                            ->withoutTime()
                            ->columnSpan(2),
                        Forms\Components\Select::make('author_id')
                            ->relationship('author', 'name')
                            ->required()
                            ->columnSpan(2),
                    ]),
                    Forms\Components\Group::make([
                        Forms\Components\SpatieTagsInput::make('tags')
                            ->type('post')
                            ->columnSpan(2),
                        AddonForms\Components\Timestamps::make()
                    ]),

                ]),
            TrovForms\Components\Meta::make()
                ->collapsed(fn ($context) => $context == 'edit'),
            Forms\Components\Section::make('Page Content')
                ->collapsible()
                ->schema([
                    TrovForms\Components\PageBuilder::make('content', [
                        Forms\Components\Builder\Block::make('rich-text')->schema([
                            TiptapEditor::make('content')
                                ->disableLabel()
                                ->profile('default')
                                ->required(),
                            ]),
                    ])
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                AddonTables\Columns\TitleWithStatus::make('title')
                    ->statuses(Status::class)
                    ->hiddenOn(Status::Published->name)
                    ->colors(Status::colors())
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('meta.indexable')
                    ->label('Indexed')
                    ->options([
                        'heroicon-o-check' => true,
                        'heroicon-o-minus' => false,
                    ])
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),
                Tables\Columns\TextColumn::make('published_at')->label('Published At')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(Status::class),
                Tables\Filters\SelectFilter::make('author_id')->label('Author')->relationship('author', 'name'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                AddonTables\Actions\PreviewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
                Tables\Actions\RestoreAction::make()->iconButton(),
                Tables\Actions\ForceDeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
