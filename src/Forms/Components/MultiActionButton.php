<?php

namespace Trov\Forms\Components;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\Concerns;

class MultiActionButton extends Action
{
    use Concerns\CanSubmitForm;

    protected string $view = 'trov::components.multi-action-button';

    protected Closure | array $actions = [];

    public function actions(Closure | array $actions): static
    {
        $this->actions = $actions;

        return $this;
    }

    public function getActions(): Closure | array
    {
        return $this->actions;
    }

    // public function toHtml(): string
    // {
    //     return $this->render()->render();
    // }

    // public function render(): View
    // {
    //     return view($this->getView(), array_merge($this->data(), [
    //         'actions' => $this->actions,
    //     ]));
    // }
}
