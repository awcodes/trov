<?php

namespace Trov\Tables\Filters;

use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class SoftDeleteFilter
{
    public static function make(): SelectFilter
    {
        return SelectFilter::make('deleted_at')
            ->options([
                'without-trashed' => 'Without Trashed',
                'only-trashed' => 'Only Trashed',
            ])
            ->label('Trashed')
            ->default('without-trashed')
            ->query(function ($query, array $data) {
                $query->when($data['value'] === 'without-trashed', function ($query) {
                    $query->withoutTrashed();
                })->when($data['value'] === 'only-trashed', function ($query) {
                    $query->onlyTrashed();
                });
            });
    }
}
