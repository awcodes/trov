<?php

namespace App\Resources;

use App\Models\Faq;
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
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use App\Forms\Components\TitleWithSlug;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use App\Tables\Filters\SoftDeleteFilter;
use Filament\Forms\Components\Placeholder;
use App\Tables\Columns\CustomTitleColumn;
use App\Resources\FaqResource\Pages\EditFaq;
use Filament\Forms\Components\SpatieTagsInput;
use App\Resources\FaqResource\Pages\ListFaqs;
use App\Resources\FaqResource\Pages\CreateFaq;
use App\Resources\RelationManagers\LinkSetsRelationManager;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class FaqResource extends Resource
{
    use HasSoftDeletes;

    protected static ?string $model = Faq::class;

    protected static ?string $label = 'FAQ';

    protected static ?string $pluralLabel = 'FAQs';

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'FAQs';

    protected static ?string $recordTitleAttribute = 'question';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        TitleWithSlug::make('question'),
                        Section::make('Answer')
                            ->schema([
                                TinyEditor::make('answer')
                                    ->label('Rich Text')
                                    ->profile('custom')
                                    ->showMenuBar()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan([
                        'lg' => 'full',
                        'xl' => 2
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
                                SpatieTagsInput::make('tags')
                                    ->type('faqTag')
                                    ->columnspan(2),
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
                CustomTitleColumn::make('question')
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
            ])->defaultSort('question', 'asc');
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
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }
}
