<?php

namespace App\Filament\Resources\Trov;

use App\Models\Page;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use TrovComponents\Enums\Status;
use TrovComponents\Filament\Panel;
use TrovComponents\Forms\Timestamps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Trov\Forms\Components\PageBuilder;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use TrovComponents\Forms\TitleWithSlug;
use Filament\Tables\Filters\SelectFilter;
use TrovComponents\Filament\FixedSidebar;
use Trov\Tables\Columns\FeaturedImageColumn;
use TrovComponents\Tables\Columns\TitleWithStatus;
use TrovComponents\Tables\Filters\SoftDeleteFilter;
use App\Filament\Resources\Trov\PageResource\Pages\EditPage;
use App\Filament\Resources\Trov\PageResource\Pages\ListPages;
use App\Filament\Resources\Trov\PageResource\Pages\CreatePage;

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
                TitleWithSlug::make('title', 'slug', '/')->columnSpan('full'),
                Section::make('Page Content')
                    ->schema([
                        PageBuilder::make('content')
                    ])
            ], [
                Panel::make('Details')
                    ->collapsible()
                    ->schema([
                        Select::make('status')
                            ->hidden(fn ($get) => $get('front_page') ?: false)
                            ->default('Draft')
                            ->options(Status::class)
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
                TitleWithStatus::make('title')
                    ->extraAttributes(['class' => 'w-full'])
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
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(Status::class),
                SoftDeleteFilter::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
