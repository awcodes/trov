<?php

namespace Trov\Resources;

use Trov\Models\Faq;
use Illuminate\Support\Str;
use Trov\Forms\Blocks\Hero;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Forms\Components\Meta;
use Trov\Traits\HasSoftDeletes;
use Filament\Resources\Resource;
use Trov\Forms\Blocks\ImageLeft;
use TrovComponents\Enums\Status;
use Trov\Forms\Blocks\ImageRight;
use Trov\Forms\Blocks\Infographic;
use TrovComponents\Filament\Panel;
use Filament\Forms\Components\Group;
use TrovComponents\Forms\Timestamps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use FilamentTipTapEditor\TipTapEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use TrovComponents\Forms\TitleWithSlug;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use TrovComponents\Filament\FixedSidebar;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Builder\Block;
use FilamentBardEditor\Components\TestBlock;
use Trov\Resources\FaqResource\Pages\EditFaq;
use Filament\Forms\Components\SpatieTagsInput;
use Trov\Resources\FaqResource\Pages\ListFaqs;
use Trov\Resources\FaqResource\Pages\CreateFaq;
use TrovComponents\Tables\Columns\TitleWithStatus;
use TrovComponents\Tables\Filters\SoftDeleteFilter;
use Trov\Resources\RelationManagers\LinkSetsRelationManager;

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

    protected static ?string $recordRouteKeyName = 'id';

    public static function form(Form $form): Form
    {
        return FixedSidebar::make($form)
            ->schema([
                TitleWithSlug::make('question', 'slug', '/faqs/')->columnSpan('full'),
                TipTapEditor::make('answer')->profile('simple')
            ], [
                Panel::make('Details')
                    ->collapsible()
                    ->schema([
                        Select::make('status')
                            ->default('Draft')
                            ->options(Status::class)
                            ->required()
                            ->columnSpan(2),
                        SpatieTagsInput::make('tags')
                            ->type('faqTag')
                            ->columnspan(2),
                        Timestamps::make()
                    ]),
                Meta::make(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TitleWithStatus::make('question')
                    ->searchable()
                    ->sortable(),
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
                SelectFilter::make('status')->options(Status::class),
                SoftDeleteFilter::make(),
            ])->defaultSort('question', 'asc');
    }

    public static function getRelations(): array
    {
        return array_merge([], config('trov.features.link_sets.active') ? [LinkSetsRelationManager::class] : []);
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
