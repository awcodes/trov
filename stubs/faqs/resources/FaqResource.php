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
use FilamentAddons\Enums\Status;
use Trov\Forms\Blocks\ImageLeft;
use Trov\Forms\Blocks\ImageRight;
use Trov\Forms\Blocks\Infographic;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use FilamentAddons\Admin\FixedSidebar;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\Builder\Block;
use FilamentBardEditor\Components\TestBlock;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use FilamentAddons\Forms\Components\Timestamps;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use FilamentAddons\Forms\Components\TitleWithSlug;
use FilamentAddons\Tables\Columns\TitleWithStatus;
use FilamentAddons\Tables\Actions\PublicViewAction;
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
        return $form->schema([
            TitleWithSlug::make('question', 'slug', '/faqs/')->columnSpan('full'),
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
            TiptapEditor::make('answer')->profile('default')->columnSpan('full'),
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
            ->defaultSort('question', 'asc');
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
