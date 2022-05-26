<?php

namespace App\Filament\Resources\Trov;

use App\Models\WhitePage;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use TrovComponents\Enums\Status;
use TrovComponents\Forms\Timestamps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use App\Forms\Trov\Components\PageBuilder;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use TrovComponents\Forms\TitleWithSlug;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use TrovComponents\Filament\FixedSidebar;
use Filament\Forms\Components\BelongsToSelect;
use TrovComponents\Tables\Columns\TitleWithStatus;
use TrovComponents\Tables\Filters\SoftDeleteFilter;
use App\Filament\Resources\Trov\WhitePageResource\Pages\EditWhitePage;
use App\Filament\Resources\Trov\WhitePageResource\Pages\ListWhitePages;
use App\Filament\Resources\Trov\WhitePageResource\Pages\CreateWhitePage;

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
                TitleWithSlug::make('title', 'slug', fn (?Model $record) => "/{$record->type}/" ?? '/')->columnSpan('full'),
                PageBuilder::make('content')
            ], [
                Section::make('Details')
                    ->collapsible()
                    ->schema([
                        Select::make('status')
                            ->default('Draft')
                            ->options(Status::class)
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
                TextColumn::make('type')->enum(self::ARTICLE_TYPES),
                TextColumn::make('published_at')->label('Published At')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(Status::class),
                SelectFilter::make('type')->options(self::ARTICLE_TYPES),
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
            'index' => ListWhitePages::route('/'),
            'create' => CreateWhitePage::route('/create'),
            'edit' => EditWhitePage::route('/{record}/edit'),
        ];
    }
}
