<?php

namespace App\Filament\Resources\Trov;

use App\Models\Runway;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use TrovComponents\Enums\Status;
use Filament\Forms\Components\Group;
use TrovComponents\Forms\Timestamps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use App\Forms\Trov\Components\PageBuilder;
use Filament\Tables\Columns\TextColumn;
use TrovComponents\Forms\TitleWithSlug;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use TrovComponents\Tables\Columns\TitleWithStatus;
use TrovComponents\Tables\Filters\SoftDeleteFilter;
use App\Filament\Resources\Trov\RunwayResource\Pages\EditRunway;
use App\Filament\Resources\Trov\RunwayResource\Pages\ListRunways;
use App\Filament\Resources\Trov\RunwayResource\Pages\CreateRunway;
use Filament\Forms\Components\Section;

class RunwayResource extends Resource
{
    use HasSoftDeletes;

    protected static ?string $model = Runway::class;

    protected static ?string $label = 'Page';

    protected static ?string $navigationGroup = 'Airport';

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $recordRouteKeyName = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        TitleWithSlug::make('title', 'slug', '/loans/'),
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
                                    ->default('Draft')
                                    ->options(Status::class)
                                    ->required()
                                    ->columnSpan(2),
                                Toggle::make('has_chat')
                                    ->columnSpan(2),
                                Timestamps::make()
                            ]),

                    ])
                    ->columnSpan([
                        'lg' => 'full',
                        'xl' => 1,
                    ]),
                Section::make('Page Content')
                    ->schema([
                        PageBuilder::make('content')
                    ])->columnSpan([
                        'xl' => 'full',
                    ])
            ])
            ->columns([
                'lg' => 3,
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
                TextColumn::make('updated_at')->label('Last Updated')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(Status::class),
                SoftDeleteFilter::make(),
            ])->defaultSort('title', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRunways::route('/'),
            'create' => CreateRunway::route('/create'),
            'edit' => EditRunway::route('/{record}/edit'),
        ];
    }
}
