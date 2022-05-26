<?php

namespace App\View\Components\Trov\Blocks;

use Illuminate\View\Component;

class ImageLeft extends Component
{
    public $media;
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->media = resolve(config('filament-curator.model'))->where('id', $data['image'])->first();
        $this->content = nl2br($data['content']);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('trov::components.blocks.image-left');
    }
}
