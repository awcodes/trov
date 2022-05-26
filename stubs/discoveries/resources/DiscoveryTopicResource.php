<?php

namespace App\Filament\Resources\Trov;

use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\DiscoveryTopic;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use TrovComponents\Enums\Status;
use Filament\Forms\Components\Group;
use TrovComponents\Forms\Timestamps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use App\Forms\Trov\Components\PageBuilder;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use TrovComponents\Forms\TitleWithSlug;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use TrovComponents\Filament\FixedSidebar;
use Filament\Forms\Components\Placeholder;
use FilamentCurator\Forms\Components\MediaPicker;
use TrovComponents\Tables\Columns\TitleWithStatus;
use TrovComponents\Tables\Filters\SoftDeleteFilter;
use App\Filament\Resources\Trov\DiscoveryTopicResource\Pages\EditDiscoveryTopic;
use App\Filament\Resources\Trov\DiscoveryTopicResource\Pages\ListDiscoveryTopics;
use App\Filament\Resources\Trov\DiscoveryTopicResource\Pages\CreateDiscoveryTopic;

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
                Textarea::make('excerpt')
                    ->required(),
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
            'index' => ListDiscoveryTopics::route('/'),
            'create' => CreateDiscoveryTopic::route('/create'),
            'edit' => EditDiscoveryTopic::route('/{record}/edit'),
        ];
    }
}
