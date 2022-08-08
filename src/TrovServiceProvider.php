<?php

namespace Trov;

use Livewire\Livewire;
use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Spatie\LaravelPackageTools\Package;

class TrovServiceProvider extends PluginServiceProvider
{
    protected array $styles = [
        'trov-styles' => __DIR__ . '/../resources/dist/trov.css',
    ];

    protected function getResources(): array
    {
        return [
            config('trov.resources.authors'),
            config('trov.resources.pages'),
            config('trov.resources.posts'),
        ];
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('trov')
            ->hasConfigFile()
            ->hasAssets()
            ->hasViews()
            ->hasRoute("web")
            ->hasCommands([
                Commands\Install::class,
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
}
