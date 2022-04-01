<?php

namespace App\Resources;

use App\Models\WhitePage;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Forms\Components\Meta;
use App\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use App\Forms\Fields\SlugInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use App\Forms\Components\Timestamps;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use App\Forms\Components\BlockContent;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use App\Forms\Components\TitleWithSlug;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Tables\Filters\SoftDeleteFilter;
use App\Tables\Columns\CustomTitleColumn;
use Filament\Forms\Components\BelongsToSelect;
use App\Resources\WhitePageResource\Pages\EditWhitePage;
use App\Resources\WhitePageResource\Pages\ListWhitePages;
use App\Resources\WhitePageResource\Pages\CreateWhitePage;
use App\Resources\RelationManagers\LinkSetsRelationManager;

class WhitePageResource extends Resource
{
    use HasSoftDeletes;

    const ARTICLE_TYPES = ['article' => 'Article', 'resource' => 'Resource'];

    protected static ?string $model = WhitePage::class;

    protected static ?string $label = 'White Page';

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        TitleWithSlug::make(),
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
                        Section::make('Details')
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
