<?php

namespace Trov\Resources;

use Illuminate\Support\Str;
use Filament\Resources\Form;
use Trov\Models\LandingPage;
use Filament\Resources\Table;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use Trov\Forms\Fields\SlugInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Trov\Forms\Components\Timestamps;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Trov\Forms\Components\TitleWithSlug;
use Filament\Tables\Filters\SelectFilter;
use Trov\Tables\Filters\SoftDeleteFilter;
use Filament\Forms\Components\Placeholder;
use Trov\Tables\Columns\CustomTitleColumn;
use Trov\Forms\Components\AirportBlockContent;
use Trov\Resources\LandingPageResource\Pages\EditLandingPage;
use Trov\Resources\LandingPageResource\Pages\ListLandingPages;
use Trov\Resources\LandingPageResource\Pages\CreateLandingPage;

class LandingPageResource extends Resource
{
    use HasSoftDeletes;

    protected static ?string $model = LandingPage::class;

    protected static ?string $label = 'Page';

    protected static ?string $navigationGroup = 'Airport';

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        TitleWithSlug::make(),
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
                        AirportBlockContent::make('content')
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
                TextColumn::make('updated_at')->label('Last Updated')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(config('trov.publishable.status')),
                SoftDeleteFilter::make(),
            ])->defaultSort('title', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLandingPages::route('/'),
            'create' => CreateLandingPage::route('/create'),
            'edit' => EditLandingPage::route('/{record}/edit'),
        ];
    }
}
