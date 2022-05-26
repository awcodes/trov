<?php

namespace App\Filament\Resources\Trov;

use App\Models\Page;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Hero;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use TrovComponents\Enums\Status;
use TrovComponents\Forms\Timestamps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use TrovComponents\Forms\TitleWithSlug;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Filters\SelectFilter;
use TrovComponents\Filament\FixedSidebar;
use App\Forms\Trov\Components\PageBuilder;
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
        return $form->schema([
            TitleWithSlug::make('title', 'slug', '/')->columnSpan('full'),
            Section::make('Details')
                ->collapsible()
                ->collapsed(fn ($livewire) => $livewire instanceof EditRecord)
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
                ->columnSpan(['md' => 1]),
            Meta::make()
                ->collapsed(fn ($livewire) => $livewire instanceof EditRecord)
                ->columnSpan(['md' => 1]),
            Hero::make('hero')
                ->collapsed(fn ($livewire) => $livewire instanceof EditRecord)
                ->collapsible(),
            Section::make('Page Content')
                ->collapsible()
                ->schema([
                    PageBuilder::make('content')
                ])
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
