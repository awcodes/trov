<?php

namespace App\Filament\Resources\Trov;

use App\Models\Faq;
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
use Filament\Forms\Components\Group;
use TrovComponents\Forms\Timestamps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use TrovComponents\Forms\TitleWithSlug;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use TrovComponents\Filament\FixedSidebar;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Builder\Block;
use FilamentBardEditor\Components\TestBlock;
use Filament\Forms\Components\SpatieTagsInput;
use TrovComponents\Tables\Columns\TitleWithStatus;
use TrovComponents\Tables\Filters\SoftDeleteFilter;
use App\Filament\Resources\Trov\FaqResource\Pages\EditFaq;
use App\Filament\Resources\Trov\FaqResource\Pages\ListFaqs;
use App\Filament\Resources\Trov\FaqResource\Pages\CreateFaq;

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
                TiptapEditor::make('answer')->profile('default')
            ], [
                Section::make('Details')
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
                TextColumn::make('updated_at')->label('Last Updated')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(Status::class),
                SoftDeleteFilter::make(),
            ])->defaultSort('question', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
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
