<?php

namespace Trov\Resources;

use Trov\Models\Page;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use Trov\Forms\Components\Panel;
use Trov\Forms\Fields\BardEditor;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Trov\Forms\Components\Timestamps;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Trov\Forms\Components\BlockContent;
use Trov\Forms\Components\FixedSidebar;
use Filament\Tables\Columns\BadgeColumn;
use Trov\Forms\Components\TitleWithSlug;
use Filament\Tables\Filters\SelectFilter;
use Trov\Tables\Filters\SoftDeleteFilter;
use Filament\Forms\Components\Placeholder;
use Trov\Tables\Columns\CustomTitleColumn;
use Trov\Tables\Columns\FeaturedImageColumn;
use Trov\Resources\PageResource\Pages\EditPage;
use Trov\Resources\PageResource\Pages\ListPages;
use Trov\Resources\PageResource\Pages\CreatePage;
use Trov\Resources\RelationManagers\LinkSetsRelationManager;

class PageResource extends Resource
{
    use HasSoftDeletes;

    protected static ?string $model = Page::class;

    protected static ?string $label = 'Page';

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationIcon = 'heroicon-o-document';

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
                            ->hidden(fn ($get) => $get('front_page') ?: false)
                            ->default('draft')
                            ->options(config('trov.publishable.status'))
                            ->required()
                            ->columnSpan('full'),
                        Select::make('layout')
                            ->hidden(fn ($get) => $get('front_page') ?: false)
                            ->default('default')
                            ->options([
                                'default' => 'Default',
                                'full' => 'Full Width'
                            ])
                            ->required()
                            ->columnSpan('full'),
                        Toggle::make('has_chat'),
                        Toggle::make('front_page')
                            ->hidden(fn (?Model $record) => $record ? $record->front_page : false)
                            ->reactive(),
                        Timestamps::make()
                    ])
                    ->columns(2),
                Meta::make(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                FeaturedImageColumn::make('featured_image')
                    ->label('Thumb'),
                CustomTitleColumn::make('title')
                    ->extraAttributes(['class' => 'w-full'])
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('status')
                    ->enum(config('trov.publishable.status'))
                    ->colors(config('trov.publishable.colors')),
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
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(config('trov.publishable.status')),
                SoftDeleteFilter::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [LinkSetsRelationManager::class,];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
