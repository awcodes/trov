<?php

namespace App\Filament\Resources\Trov;

use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\DiscoveryTopic;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use FilamentAddons\Enums\Status;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use FilamentAddons\Admin\FixedSidebar;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use App\Forms\Trov\Components\PageBuilder;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use FilamentAddons\Forms\Components\Timestamps;
use FilamentCurator\Forms\Components\MediaPicker;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use FilamentAddons\Forms\Components\TitleWithSlug;
use FilamentAddons\Tables\Columns\TitleWithStatus;
use FilamentAddons\Tables\Actions\PublicViewAction;
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
        return $form
            ->schema([
                TitleWithSlug::make('title', 'slug', '/discover/topics/')->columnSpan('full'),
                Section::make('Details')
                    ->collapsible()
                    ->collapsed(fn ($livewire) => $livewire instanceof EditRecord)
                    ->columns(['md' => 2])
                    ->schema([
                        Select::make('status')
                            ->default('Draft')
                            ->options(Status::class)
                            ->required(),
                        DatePicker::make('published_at')
                            ->label('Publish Date'),
                        Timestamps::make()
                    ]),
                Meta::make()
                    ->collapsed(fn ($livewire) => $livewire instanceof EditRecord),
                Section::make('Excerpt')
                    ->collapsible()
                    ->schema([
                        Textarea::make('excerpt')
                            ->required()
                            ->disableLabel(),
                    ])->collapsed(fn ($livewire) => $livewire instanceof EditRecord),
                Section::make('Page Content')
                    ->collapsible()
                    ->schema([
                        PageBuilder::make('content')
                    ]),
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
            'index' => ListDiscoveryTopics::route('/'),
            'create' => CreateDiscoveryTopic::route('/create'),
            'edit' => EditDiscoveryTopic::route('/{record}/edit'),
        ];
    }
}
