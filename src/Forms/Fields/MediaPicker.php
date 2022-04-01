<?php

namespace Trov\Forms\Fields;

use Trov\Models\Media;
use Filament\Forms\Components\Field;

class MediaPicker extends Field
{
    protected string $view = 'trov::components.fields.media-picker';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (MediaPicker $component, Media $media, $state): void {
            $item = $media->where('id', $state)->first();
            if ($item instanceof Media) {
                $component->state($item);
            }
        });

        $this->dehydrateStateUsing(function ($state): ?int {
            return isset($state['id']) ? $state['id'] : null;
        });
    }
}
