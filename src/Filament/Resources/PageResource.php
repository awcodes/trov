<?php

namespace Trov\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

use Trov\Models\Page;
use Trov\Forms as TrovForms;
use Trov\Filament\Resources\PageResource\Pages;

use FilamentTiptapEditor\TiptapEditor;

use FilamentAddons\Enums\Status;
use FilamentAddons\Tables as AddonTables;
use FilamentAddons\Forms as AddonForms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $label = 'Page';

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $recordRouteKeyName = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            AddonForms\Components\TitleWithSlug::make('title', 'slug', '/')->columnSpan('full'),
            Forms\Components\Section::make('Details')
                ->collapsible()
                ->collapsed(fn ($context) => $context == 'edit')
                ->schema([
                    Forms\Components\Grid::make(['md' => 2, 'lg' => null])
                        ->schema([
                            Forms\Components\Select::make('status')
                                ->disabled(fn ($get) => $get('front_page') ?: false)
                                ->default('Draft')
                                ->options(Status::class)
                                ->required(),
                            Forms\Components\Select::make('layout')
                                ->disabled(fn ($get) => $get('front_page') ?: false)
                                ->default('default')
                                ->options([
                                    'default' => 'Default',
                                    'full' => 'Full Width'
                                ])
                                ->required(),
                        ]),
                    Forms\Components\Grid::make(['md' => 2, 'lg' => null])
                        ->schema([
                            AddonForms\Components\Timestamps::make()->columnSpan(1),
                            Forms\Components\Toggle::make('front_page')
                                ->disabled(fn (?Model $record) => $record ? $record->front_page : false)
                                ->reactive(),
                        ])
                ]),
            TrovForms\Components\Meta::make()
                ->collapsed(fn ($context) => $context == 'edit'),
            TrovForms\Components\Hero::make('hero')
                ->collapsed(fn ($context) => $context == 'edit')
                ->collapsible(),
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
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(Status::class),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
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
