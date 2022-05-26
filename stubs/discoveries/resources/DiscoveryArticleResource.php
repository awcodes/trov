<?php

namespace App\Filament\Resources\Trov;

use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use App\Models\DiscoveryArticle;
use Filament\Resources\Resource;
use TrovComponents\Enums\Status;
use Filament\Forms\Components\Group;
use TrovComponents\Forms\Timestamps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use TrovComponents\Forms\TitleWithSlug;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use TrovComponents\Filament\FixedSidebar;
use App\Forms\Trov\Components\PageBuilder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\BelongsToSelect;
use FilamentCurator\Forms\Components\MediaPicker;
use TrovComponents\Tables\Columns\TitleWithStatus;
use TrovComponents\Tables\Filters\SoftDeleteFilter;
use App\Filament\Resources\Trov\DiscoveryArticleResource\Pages\EditDiscoveryArticle;
use App\Filament\Resources\Trov\DiscoveryArticleResource\Pages\ListDiscoveryArticles;
use App\Filament\Resources\Trov\DiscoveryArticleResource\Pages\CreateDiscoveryArticle;

class DiscoveryArticleResource extends Resource
{
    use HasSoftDeletes;

    protected static ?string $model = DiscoveryArticle::class;

    protected static ?string $label = 'Article';

    protected static ?string $navigationLabel = 'Articles';

    protected static ?string $navigationGroup = 'Discovery Center';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $recordRouteKeyName = 'id';

    public static function form(Form $form): Form
    {
        return FixedSidebar::make()
            ->schema([
                TitleWithSlug::make('title', 'slug', '/discover/')->columnSpan('full'),
                Section::make('Page Content')
                    ->schema([
                        PageBuilder::make('content')
                    ])
            ], [
                Section::make('Details')
                    ->collapsible()
                    ->schema([
                        Select::make('status')
                            ->default('Draft')
                            ->options(Status::class)
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TitleWithStatus::make('title')
                    ->statuses(Status::class)
                    ->hiddenOn(Status::Published->name)
                    ->colors(Status::colors())
                    ->searchable()
                    ->sortable(),
                TextColumn::make('topic.title')->searchable()->sortable(),
                IconColumn::make('meta.indexable')
                    ->label('Indexed')
                    ->options([
                        'heroicon-o-check' => true,
                        'heroicon-o-minus' => false,
                    ])
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),
                TextColumn::make('published_at')->label('Published At')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(Status::class),
                SelectFilter::make('discovery_topic_id')->label('Topic')->relationship('topic', 'title'),
                SelectFilter::make('author_id')->label('Author')->relationship('author', 'name'),
                SoftDeleteFilter::make(),
            ])->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
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
