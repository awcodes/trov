<?php

namespace Trov\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class FrameworkOverview extends Widget
{
    public $pages;

    protected static string $view = 'trov::components.widgets.framework-overview';
}
