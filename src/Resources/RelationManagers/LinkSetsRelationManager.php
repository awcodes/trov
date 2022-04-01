<?php

namespace Trov\Resources\RelationManagers;

use Filament\Resources\Form;
use Filament\Resources\Table;
use Trov\Resources\LinkSetResource;
use Filament\Resources\RelationManagers\MorphManyRelationManager;

class LinkSetsRelationManager extends MorphManyRelationManager
{
    protected static string $relationship = 'linkSets';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Internal Linking Set';

    protected static ?string $title = 'Internal Linking Sets';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(LinkSetResource::getFormSchema())
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(LinkSetResource::getTableColumns())
            ->filters([
                //
            ]);
    }
}
