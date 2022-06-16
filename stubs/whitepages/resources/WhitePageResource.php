<?php

namespace App\Filament\Resources\Trov;

use App\Models\WhitePage;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use FilamentAddons\Enums\Status;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use FilamentAddons\Admin\FixedSidebar;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use App\Forms\Trov\Components\PageBuilder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use FilamentAddons\Forms\Components\Timestamps;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use FilamentAddons\Forms\Components\TitleWithSlug;
use FilamentAddons\Tables\Columns\TitleWithStatus;
use FilamentAddons\Tables\Actions\PublicViewAction;
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
        return $form
            ->schema([
                TitleWithSlug::make('title', 'slug', fn (?Model $record) => "/{$record->type}/" ?? '/')->columnSpan('full'),
                Section::make('Details')
                    ->collapsible()
                    ->collapsed(fn ($livewire) => $livewire instanceof EditRecord)
                    ->columns(['md' => 2])
                    ->schema([
                        Select::make('status')
                            ->default('Draft')
                            ->options(Status::class)
                            ->required(),
                        Select::make('type')
                            ->default('article')
                            ->reactive()
                            ->options(self::ARTICLE_TYPES)->required(),
                        BelongsToSelect::make('author_id')
                            ->relationship('author', 'name')
                            ->required(),
                        DatePicker::make('published_at')
                            ->label('Publish Date'),
                        Timestamps::make()
                    ]),
                Meta::make(),
                PageBuilder::make('content')->columnSpan('full'),
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
                TrashedFilter::make(),
            ])
            ->actions([
                PublicViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
                RestoreBulkAction::make(),
                ForceDeleteBulkAction::make(),
            ])
            ->defaultSort('published_at', 'desc');
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
