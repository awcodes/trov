<?php

namespace Trov\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class PostsOverview extends Widget
{
    public $posts;

    protected static string $view = 'trov::components.widgets.posts-overview';

    public function mount()
    {
        $this->posts = DB::table('posts')
            ->select('status', DB::raw('count(*) as total'))
            ->where('deleted_at', null)
            ->groupBy('status')
            ->get();
    }
}
