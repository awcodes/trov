<?php

namespace Trov\Resources;

use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Models\DiscoveryTopic;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use TrovComponents\Enums\Status;
use TrovComponents\Filament\Panel;
use Filament\Forms\Components\Group;
use TrovComponents\Forms\Timestamps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use TrovComponents\Forms\TitleWithSlug;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Trov\Forms\Components\FeaturedImage;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use TrovComponents\Filament\FixedSidebar;
use Filament\Forms\Components\Placeholder;
use Trov\Tables\Columns\FeaturedImageColumn;
use FilamentCurator\Forms\Components\MediaPicker;
use Trov\Forms\Components\PageBuilder;
use TrovComponents\Tables\Columns\TitleWithStatus;
use TrovComponents\Tables\Filters\SoftDeleteFilter;
use Trov\Resources\RelationManagers\LinkSetsRelationManager;
use Trov\Resources\DiscoveryTopicResource\Pages\EditDiscoveryTopic;
use Trov\Resources\DiscoveryTopicResource\Pages\ListDiscoveryTopics;
use Trov\Resources\DiscoveryTopicResource\Pages\CreateDiscoveryTopic;

class DiscoveryTopicResource extends Resource
{
    use HasSoftDeletes;

    protected static ?string $model = DiscoveryTopic::class;

    protected static ?string $label = 'Topic';

    protected static ?string $navigationLabel = 'Topics';

    protected static ?string $navigationGroup = 'Discovery Center';

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $recordRouteKeyName = 'id';

    public static function form(Form $form): Form
    {
        return FixedSidebar::make()
            ->schema([
                TitleWithSlug::make('title', 'slug', '/discover/topics/')->columnSpan('full'),
                FeaturedImage::make(),
                Section::make('Page Content')
                    ->schema([
                        PageBuilder::make('content')
                    ])
            ], [
                Panel::make('Details')
                    ->collapsible()
                    ->schema([
                        Select::make('status')
                            ->default('Draft')
                            ->options(Status::class)
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
                FeaturedImageColumn::make('featured_image')->label('Thumb'),
                TitleWithStatus::make('title')
                    ->searchable()
                    ->sortable(),
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
                SelectFilter::make('status')->options(Status::class),
                SoftDeleteFilter::make(),
            ])->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return array_merge([], config('trov.features.link_sets.active') ? [LinkSetsRelationManager::class] : []);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDiscoveryTopics::route('/'),
            'create' => CreateDiscoveryTopic::route('/create'),
            'edit' => EditDiscoveryTopic::route('/{record}/edit'),
        ];
    }
}
