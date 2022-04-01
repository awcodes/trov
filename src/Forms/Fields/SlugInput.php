<?php

namespace Trov\Forms\Fields;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Arrayable;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Concerns\HasExtraAlpineAttributes;

class SlugInput extends TextInput
{
    protected string $view = 'trov::components.fields.slug-input';

    protected string | Closure | null $mode = null;

    protected bool $cancelled = false;

    public function mode(string | Closure | null $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->evaluate($this->mode);
    }

    public function getBaseUrl(): ?string
    {
        return trailingSlashIt(config('app.url') . $this->getModelInstance()->getBasePath());
    }

    public function cancelChange()
    {
        return null;
    }
}
