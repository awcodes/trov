<?php

namespace Trov;

use App\Models\Page;
use App\Models\User;
use Livewire\Livewire;
use Filament\Facades\Filament;
use Trov\Observers\PageObserver;
use Trov\Observers\UserObserver;
use Filament\PluginServiceProvider;
use Illuminate\Contracts\View\View;
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
            ->hasRoute("web")
            ->hasCommands([
                Commands\Install::class,
                Commands\InstallCore::class,
                Commands\InstallFaqs::class,
                Commands\InstallWhitePages::class,
                Commands\InstallDiscoveries::class,
                Commands\InstallLinkables::class,
                Commands\InstallAirport::class,
            ])
            ->hasMigrations([
                'create_authors_table',
                'create_metas_table',
                'create_pages_table',
                'create_posts_table',
            ]);
    }

    public function register()
    {
        parent::register();

        foreach (glob(__DIR__ . '/Helpers/*.php') as $file) {
            require_once $file;
        }
    }

    public function boot()
    {
        parent::boot();

        User::observe(UserObserver::class);

        $this->publishes([
            __DIR__ . '/../stubs/faqs/database/migrations/' => database_path('migrations')
        ], 'trov-faqs-migrations');

        $this->publishes([
            __DIR__ . '/../stubs/whitepages/database/migrations/' => database_path('migrations')
        ], 'trov-whitepages-migrations');

        $this->publishes([
            __DIR__ . '/../stubs/discoveries/database/migrations/' => database_path('migrations'),
        ], 'trov-discoveries-migrations');

        $this->publishes([
            __DIR__ . '/../stubs/linkables/database/migrations/' => database_path('migrations'),
        ], 'trov-linkables-migrations');

        $this->publishes([
            __DIR__ . '/../stubs/airport/database/migrations/' => database_path('migrations'),
        ], 'trov-airport-migrations');
    }
}
