<?php

namespace Trov\Resources;

use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use Trov\Forms\Fields\SlugInput;
use Trov\Models\DiscoveryArticle;
use Trov\Forms\Fields\MediaPicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Trov\Forms\Components\Timestamps;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Trov\Forms\Components\BlockContent;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Trov\Forms\Components\FeaturedImage;
use Trov\Forms\Components\TitleWithSlug;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Trov\Tables\Filters\SoftDeleteFilter;
use Filament\Forms\Components\Placeholder;
use Trov\Tables\Columns\CustomTitleColumn;
use Trov\Tables\Columns\FeaturedImageColumn;
use Filament\Forms\Components\BelongsToSelect;
use Trov\Forms\Components\Panel;
use Trov\Resources\RelationManagers\LinkSetsRelationManager;
use Trov\Resources\DiscoveryArticleResource\Pages\EditDiscoveryArticle;
use Trov\Resources\DiscoveryArticleResource\Pages\ListDiscoveryArticles;
use Trov\Resources\DiscoveryArticleResource\Pages\CreateDiscoveryArticle;

class DiscoveryArticleResource extends Resource
{
    use HasSoftDeletes;

    protected static ?string $model = DiscoveryArticle::class;

    protected static ?string $label = 'Article';

    protected static ?string $navigationLabel = 'Articles';

    protected static ?string $navigationGroup = 'Discovery Center';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        TitleWithSlug::make(),
                        FeaturedImage::make(),
                        Section::make('Page Content')
                            ->schema([
                                BlockContent::make('content')
                            ])
                    ])
                    ->columnSpan([
                        'lg' => 'full',
                        'xl' => 2,
                    ]),
                Group::make()
                    ->schema([
                        Panel::make('Details')
                            ->collapsible()
                            ->schema([
                                Select::make('status')
                                    ->default('draft')
                                    ->options(config('trov.publishable.status'))
                                    ->required()
                                    ->columnSpan(2),
                                DatePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->withoutSeconds()
                                    ->columnSpan(2),
                                BelongsToSelect::make('discovery_topic_id')
                                    ->relationship('topic', 'title')
                                    ->required()
                                    ->columnSpan(2),
                                BelongsToSelect::make('author_id')
                                    ->relationship('author', 'name')
                                    ->required()
                                    ->columnSpan(2),
                                Timestamps::make()
                            ]),
                        Meta::make(),
                    ])
                    ->columnSpan([
                        'lg' => 'full',
                        'xl' => 1,
                    ]),
            ])->columns([
                'lg' => 3,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                FeaturedImageColumn::make('featured_image')->label('Thumb'),
                CustomTitleColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('topic.title')->searchable()->sortable(),
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
                TextColumn::make('published_at')->label('Published At')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(config('trov.publishable.status')),
                SelectFilter::make('discovery_topic_id')->label('Topic')->relationship('topic', 'title'),
                SelectFilter::make('author_id')->label('Author')->relationship('author', 'name'),
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
            'index' => ListDiscoveryArticles::route('/'),
            'create' => CreateDiscoveryArticle::route('/create'),
            'edit' => EditDiscoveryArticle::route('/{record}/edit'),
        ];
    }
}
