<?php

namespace Trov\Forms\Fields;

use Filament\Forms\Components\Field;
use Illuminate\Contracts\Support\Arrayable;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;

class RadioButton extends Field
{
    use HasExtraInputAttributes;

    protected string $view = 'trov::components.fields.radio-button';

    protected bool | Closure $isInline = false;

    protected array | Arrayable | Closure $options = [];

    protected array | Arrayable | Closure $descriptions = [];

    protected bool | Closure | null $isOptionDisabled = null;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function boolean(string $trueLabel = 'Yes', string $falseLabel = 'No'): static
    {
        $this->options([
            1 => $trueLabel,
            0 => $falseLabel,
        ]);

        return $this;
    }

    public function disableOptionWhen(bool | Closure $callback): static
    {
        $this->isOptionDisabled = $callback;

        return $this;
    }

    public function inline(bool | Closure $condition = true): static
    {
        $this->isInline = $condition;

        return $this;
    }

    public function options(array | Arrayable | Closure $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function descriptions(array | Arrayable | Closure $descriptions): static
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    public function hasDescription($value): bool
    {
        return array_key_exists($value, $this->getDescriptions());
    }

    public function getDescription($value): ?string
    {
        return $this->getDescriptions()[$value] ?? null;
    }

    public function getDescriptions(): array
    {
        $descriptions = $this->evaluate($this->descriptions);

        if ($descriptions instanceof Arrayable) {
            $descriptions = $descriptions->toArray();
        }

        return $descriptions;
    }

    public function getOptions(): array
    {
        $options = $this->evaluate($this->options);

        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        return $options;
    }

    public function isInline(): bool
    {
        return (bool) $this->evaluate($this->isInline);
    }

    public function isOptionDisabled($value, string $label): bool
    {
        if ($this->isOptionDisabled === null) {
            return false;
        }

        return (bool) $this->evaluate($this->isOptionDisabled, [
            'label' => $label,
            'value' => $value,
        ]);
    }
}
