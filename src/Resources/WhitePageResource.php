<?php

namespace Trov\Resources;

use Trov\Models\WhitePage;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use Trov\Forms\Components\Panel;
use Trov\Forms\Fields\SlugInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Trov\Forms\Components\Timestamps;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Trov\Forms\Components\BlockContent;
use Trov\Forms\Components\FixedSidebar;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Trov\Forms\Components\TitleWithSlug;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Trov\Tables\Filters\SoftDeleteFilter;
use Trov\Tables\Columns\CustomTitleColumn;
use Filament\Forms\Components\BelongsToSelect;
use Trov\Resources\WhitePageResource\Pages\EditWhitePage;
use Trov\Resources\WhitePageResource\Pages\ListWhitePages;
use Trov\Resources\WhitePageResource\Pages\CreateWhitePage;
use Trov\Resources\RelationManagers\LinkSetsRelationManager;

class WhitePageResource extends Resource
{
    use HasSoftDeletes;

    const ARTICLE_TYPES = ['article' => 'Article', 'resource' => 'Resource'];

    protected static ?string $model = WhitePage::class;

    protected static ?string $label = 'White Page';

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $recordRouteKeyName = 'id';

    public static function form(Form $form): Form
    {
        return FixedSidebar::make()
            ->schema([
                TitleWithSlug::make()->columnSpan('full'),
                Section::make('Page Content')
                    ->schema([
                        BlockContent::make('content')
                    ])
            ], [
                Panel::make('Details')
                    ->collapsible()
                    ->schema([
                        Select::make('status')
                            ->default('draft')
                            ->options(config('trov.publishable.status'))
                            ->required()
                            ->columnSpan(2),
                        Select::make('type')
                            ->default('article')
                            ->reactive()
                            ->options(self::ARTICLE_TYPES)->required()
                            ->columnSpan(2),
                        BelongsToSelect::make('author_id')
                            ->relationship('author', 'name')
                            ->required()
                            ->columnSpan(2),
                        DatePicker::make('published_at')
                            ->label('Publish Date')
                            ->columnSpan(2),
                        Timestamps::make()
                    ]),
                Meta::make(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CustomTitleColumn::make('title')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('status')->enum(config('trov.publishable.status'))->colors(config('trov.publishable.colors')),
                BadgeColumn::make('meta.indexable')
                    ->label('SEO')
                    ->enum([
                        true => 'Index',
                        false => '—',
                    ])
                    ->colors([
                        'success' => true,
                        'secondary' => false,
                    ]),
                TextColumn::make('type')->enum(self::ARTICLE_TYPES),
                TextColumn::make('published_at')->label('Published At')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(config('trov.publishable.status')),
                SelectFilter::make('type')->options(self::ARTICLE_TYPES),
                SoftDeleteFilter::make(),
            ])->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            LinkSetsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWhitePages::route('/'),
            'create' => CreateWhitePage::route('/create'),
            'edit' => EditWhitePage::route('/{record}/edit'),
        ];
    }
}
