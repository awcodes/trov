<?php

namespace App\View\Components\Trov\Blocks;

use Illuminate\View\Component;

class Image extends Component
{
    public $media;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->media = resolve(config('filament-curator.model'))->where('id', $data['image'])->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('trov::components.blocks.image');
    }
}
