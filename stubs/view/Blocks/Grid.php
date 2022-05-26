<?php

namespace App\View\Components\Trov\Blocks;

use Illuminate\View\Component;

class Grid extends Component
{
    public $columns = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        if ($data['columns']) {
            foreach ($data['columns'] as $column) {
                $this->columns[] = [
                    'content' => $column['content'],
                ];
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('trov::components.blocks.grid');
    }
}
