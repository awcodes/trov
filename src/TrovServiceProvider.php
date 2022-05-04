<?php

namespace Trov;

use App\Models\User;
use App\Models\Page;
use Livewire\Livewire;
use Filament\Facades\Filament;
use Trov\Observers\PageObserver;
use Trov\Observers\UserObserver;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\File;
use Spatie\LaravelPackageTools\Package;

class TrovServiceProvider extends PluginServiceProvider
{
    protected array $styles = [
        'trov-styles' => __DIR__ . '/../resources/dist/trov.css',
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('trov')
            ->hasConfigFile(['trov', 'filament', 'filament-breezy', 'filament-shield'])
            ->hasAssets()
            ->hasViews()
            ->hasCommands([
                Commands\InstallTrov::class,
                Commands\EjectTrovResources::class,
                Commands\EjectTrovModels::class,
            ])
            ->hasMigrations([
                'create_trov_tables',
            ]);
    }

    public function register()
    {
        parent::register();

        require_once __DIR__ . '/Helpers.php';
    }

    public function boot()
    {
        parent::boot();

        Livewire::component('framework-overview', Widgets\FrameworkOverview::class);
        Livewire::component('pages-overview', Widgets\PagesOverview::class);
        Livewire::component('posts-overview', Widgets\PostsOverview::class);

        User::observe(UserObserver::class);
    }
}
