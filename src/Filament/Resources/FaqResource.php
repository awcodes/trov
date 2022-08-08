<?php

namespace Trov\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;

use Trov\Models\Faq;

use Trov\Forms as TrovForms;

use FilamentAddons\Enums\Status;
use FilamentAddons\Tables as AddonTables;
use FilamentAddons\Forms as AddonForms;

use FilamentTiptapEditor\TiptapEditor;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Trov\Filament\Resources\FaqResource\Pages;

class FaqResource extends Resource
{
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
            AddonForms\Components\TitleWithSlug::make('question', 'slug', '/faqs/')->columnSpan('full'),
            Forms\Components\Section::make('Details')
                ->collapsible()
                ->collapsed(fn (string $context): bool => $context == 'edit')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->default('Draft')
                        ->options(Status::class)
                        ->required(),
                    Forms\Components\SpatieTagsInput::make('tags')
                        ->type('faqTag'),
                    AddonForms\Components\Timestamps::make()
                ])->columns(['md' => 2]),
            TrovForms\Components\Meta::make()->collapsed(fn (string $context): bool => $context == 'edit'),
            TiptapEditor::make('answer')->profile('default')->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                AddonTables\Columns\TitleWithStatus::make('question')
                    ->statuses(Status::class)
                    ->hiddenOn(Status::Published->name)
                    ->colors(Status::colors())
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('meta.indexable')
                    ->label('Indexed')
                    ->options([
                        'heroicon-o-check' => true,
                        'heroicon-o-minus' => false,
                    ])
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),
                Tables\Columns\TextColumn::make('updated_at')->label('Last Updated')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(Status::class),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                AddonTables\Actions\PreviewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
                Tables\Actions\RestoreAction::make()->iconButton(),
                Tables\Actions\ForceDeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
