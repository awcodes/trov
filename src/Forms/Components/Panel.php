<?php

namespace Trov\Forms\Components;

use Closure;
use Illuminate\Support\Str;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Contracts\CanConcealComponents;
use Filament\Forms\Components\Concerns\HasExtraAlpineAttributes;

class Panel extends Component implements CanConcealComponents
{
    use HasExtraAlpineAttributes;

    protected string $view = 'trov::components.panel';

    protected bool | Closure $isCollapsed = false;

    protected bool | Closure $isCollapsible = false;

    protected string | Closure | null $description = null;

    protected string | Closure $heading;

    final public function __construct(string | Closure $heading)
    {
        $this->heading($heading);
    }

    public static function make(string | Closure $heading): static
    {
        $static = app(static::class, ['heading' => $heading]);
        $static->setUp();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->columnSpan('full');
    }

    public function collapsed(bool | Closure $condition = true): static
    {
        $this->isCollapsed = $condition;
        $this->collapsible(true);

        return $this;
    }

    public function collapsible(bool | Closure $condition = true): static
    {
        $this->isCollapsible = $condition;

        return $this;
    }

    public function description(string | Closure | null $description = null): static
    {
        $this->description = $description;

        return $this;
    }

    public function heading(string | Closure $heading): static
    {
        $this->heading = $heading;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->evaluate($this->description);
    }

    public function getHeading(): string
    {
        return $this->evaluate($this->heading);
    }

    public function getId(): ?string
    {
        $id = parent::getId();

        if (!$id) {
            $id = Str::slug($this->getHeading());

            if ($statePath = $this->getStatePath()) {
                $id = "{$statePath}.{$id}";
            }
        }

        return $id;
    }

    public function isCollapsed(): bool
    {
        return (bool) $this->evaluate($this->isCollapsed);
    }

    public function isCollapsible(): bool
    {
        return (bool) $this->evaluate($this->isCollapsible);
    }
}
