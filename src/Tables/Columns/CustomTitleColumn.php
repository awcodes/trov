<?php

namespace Trov\Tables\Columns;

use Illuminate\Support\HtmlString;
use Filament\Tables\Columns\TextColumn;

class CustomTitleColumn extends TextColumn
{
    protected function setUp(): void
    {
        $this->formatStateUsing(function ($record, $state) {
            if ($record->front_page) {
                return new HtmlString($state . ' — <strong class="px-2 py-1 text-xs text-white bg-gray-900 rounded-md">Front Page</strong>');
            }

            return $record->deleted_at ? new HtmlString($state . ' — <strong class="px-2 py-1 text-xs text-white bg-gray-900 rounded-md">Trashed</strong>') : $state;
        });
    }
}
