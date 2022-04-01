<?php

namespace Trov\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class PagesOverview extends Widget
{
    public $pages;

    protected static string $view = 'trov::components.widgets.pages-overview';

    public function mount()
    {
        $this->pages = DB::table('pages')
            ->select('status', DB::raw('count(*) as total'))
            ->where('deleted_at', null)
            ->groupBy('status')
            ->get();
    }
}
