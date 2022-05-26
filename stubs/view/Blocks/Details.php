<?php

namespace App\View\Components\Trov\Blocks;

use Illuminate\View\Component;

class Details extends Component
{
    public $summary;
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->summary = $data['summary'];
        $this->content = $data['content'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('trov::components.blocks.details');
    }
}
