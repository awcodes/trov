<?php

namespace Trov\Resources;

use Trov\Models\Faq;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use Trov\Forms\Components\Panel;
use Trov\Forms\Fields\SlugInput;
use FilamentBardEditor\BardEditor;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Trov\Forms\Components\Timestamps;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Trov\Forms\Components\TitleWithSlug;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Trov\Tables\Filters\SoftDeleteFilter;
use Filament\Forms\Components\Placeholder;
use Trov\Tables\Columns\CustomTitleColumn;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use FilamentBardEditor\Components\TestBlock;
use Trov\Resources\FaqResource\Pages\EditFaq;
use Filament\Forms\Components\SpatieTagsInput;
use Trov\Resources\FaqResource\Pages\ListFaqs;
use Trov\Resources\FaqResource\Pages\CreateFaq;
use Trov\Resources\RelationManagers\LinkSetsRelationManager;
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
                                BardEditor::make('answer')
                                    ->excludes(['blockquote', 'subscript'])
                                    ->blocks([
                                        Block::make('infographic')
                                            ->schema([
                                                TextInput::make('name')->required(),
                                                Textarea::make('transcript'),
                                            ]),
                                        Block::make('social_media')
                                            ->schema([
                                                TextInput::make('facebook'),
                                                TextInput::make('twitter'),
                                                TextInput::make('instagram'),
                                                TextInput::make('linkedin'),
                                            ]),
                                    ]),
                            ]),
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
