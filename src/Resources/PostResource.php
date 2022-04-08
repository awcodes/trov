<?php

namespace Trov\Resources;

use Trov\Models\Post;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use Trov\Forms\Fields\DateInput;
use Trov\Forms\Fields\SlugInput;
use Trov\Forms\Fields\MediaPicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Trov\Forms\Components\Timestamps;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Trov\Forms\Components\BlockContent;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Trov\Forms\Components\FeaturedImage;
use Trov\Forms\Components\TitleWithSlug;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Trov\Tables\Filters\SoftDeleteFilter;
use Trov\Tables\Columns\CustomTitleColumn;
use Trov\Tables\Columns\FeaturedImageColumn;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\SpatieTagsInput;
use FilamentBardEditor\BardEditor;
use Trov\Forms\Components\Panel;
use Trov\Resources\PostResource\Pages\EditPost;
use Trov\Resources\PostResource\Pages\ListPosts;
use Trov\Resources\PostResource\Pages\CreatePost;
use Trov\Resources\RelationManagers\LinkSetsRelationManager;

class PostResource extends Resource
{
    use HasSoftDeletes;

    protected static ?string $model = Post::class;

    protected static ?string $label = 'Post';

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationLabel = "Blog Posts";

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        TitleWithSlug::make(),
                        Section::make('Post Content')
                            ->schema([
                                BlockContent::make('content')
                            ])
                    ])
                    ->columnSpan([
                        'lg' => 'full',
                        'xl' => 2
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
                                DateInput::make('published_at')
                                    ->label('Publish Date')
                                    ->withoutTime()
                                    ->columnSpan(2),
                                BelongsToSelect::make('author_id')
                                    ->relationship('author', 'name')
                                    ->required()
                                    ->columnSpan(2),
                                SpatieTagsInput::make('tags')
                                    ->type('postTag')
                                    ->columnSpan(2),
                                Timestamps::make()
                            ]),
                        Meta::make(),
                    ])
                    ->columnSpan([
                        'lg' => 'full',
                        'xl' => 1,
                    ]),
            ])
            ->columns([
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
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
