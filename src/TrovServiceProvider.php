<?php

namespace Trov;

use App\Models\User;
use Trov\Models\Page;
use Livewire\Livewire;
use Filament\Facades\Filament;
use Trov\Observers\PageObserver;
use Trov\Observers\UserObserver;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\File;
use Spatie\LaravelPackageTools\Package;

class TrovServiceProvider extends PluginServiceProvider
{
    protected array $resources = [];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('trov')
            ->hasConfigFile(['trov', 'filament', 'filament-breezy', 'filament-shield'])
            ->hasAssets()
            ->hasViews()
            ->hasCommands([
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

        Filament::serving(function () {
            Filament::registerTheme(asset('vendor/trov/trov.css'));
        });

        Livewire::component('framework-overview', Widgets\FrameworkOverview::class);
        Livewire::component('pages-overview', Widgets\PagesOverview::class);
        Livewire::component('posts-overview', Widgets\PostsOverview::class);

        User::observe(UserObserver::class);
        Page::observe(PageObserver::class);
    }

    protected function getResources(): array
    {
        $resources = [
            Resources\UserResource::class,
            Resources\PageResource::class,
            Resources\AuthorResource::class,
            Resources\PostResource::class,
        ];

        if (!File::exists(app_path('Filament/Resources/Trov/UserResource.php'))) {
            return $resources;
        }

        return $this->resources;
    }
}
