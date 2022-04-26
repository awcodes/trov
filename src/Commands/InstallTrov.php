<?php

namespace Trov\Commands;

use Filament\Facades\Filament;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InstallTrov extends Command
{
    use Concerns\CanManipulateFiles;
    use Concerns\CanBackupAFile;

    public $signature = 'trov:install
        {--F|fresh}
    ';
    public $description = "Installs Trov CMS starter.";

    public function handle(): int
    {
        $this->alert('Following operations will be performed:');
        $this->info('- Publishes core package config');
        $this->info('- Publishes core package migration');
        $this->warn('  - On fresh applications database will be migrated');
        $this->warn('  - You can also force this behavior by supplying the --fresh option');
        $this->info('- Discovers filament resources and generates Permissions and Policies accordingly');
        $this->info('- Publishes Resources & Pages');

        $confirmed = $this->confirm('Do you wish to continue?', true);

        if ($this->CheckIfAlreadyInstalled() && !$this->option('fresh')) {
            $this->comment('Seems you have already installed the Core package!');
            $this->comment('You should run `trov:install --fresh` instead to refresh the Core package tables and setup Trov.');

            if ($this->confirm('Run `trov:install --fresh` instead?', false)) {
                $this->install(true);
            }

            return self::INVALID;
        }

        if ($confirmed) {
            $this->install($this->option('fresh'));
        } else {
            $this->comment('`trov:install` command was cancelled.');
        }

        return self::SUCCESS;
    }

    protected function CheckIfAlreadyInstalled(): bool
    {
        $count = $this->getTables()
            ->filter(function ($table) {
                return Schema::hasTable($table);
            })
            ->count();
        if ($count !== 0) {
            return true;
        }

        return false;
    }

    protected function getTables(): Collection
    {
        return collect(['pages', 'posts', 'authors', 'metas', 'tags', 'taggables']);
    }

    protected function install(bool $fresh = false)
    {
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\Tags\TagsServiceProvider',
            '--provider' => 'Trov\TrovServiceProvider',
        ]);

        $this->info('Core configs published.');

        if ($fresh) {
            try {
                Schema::disableForeignKeyConstraints();
                DB::table('migrations')->where('migration', 'like', '%_create_trov_tables')->delete();
                $this->getTables()->each(fn ($table) => DB::statement('DROP TABLE IF EXISTS ' . $table));
                Schema::enableForeignKeyConstraints();
            } catch (\Throwable $e) {
                $this->info($e);
            }

            $this->call('migrate');
            $this->info('Database migrations freshened up.');

            (new Filesystem())->ensureDirectoryExists(config_path());

            if ($this->isBackupPossible(
                config_path('trov.php'),
                config_path('trov.php.bak')
            )) {
                $this->info('Config backup created.');
            }

            (new Filesystem())->copy(__DIR__ . '/../../config/trov.php', config_path('trov.php'));
        } else {
            $this->call('migrate');
            $this->info('Database migrated.');
        }

        (new Filesystem())->ensureDirectoryExists(lang_path());
        (new Filesystem())->copyDirectory(__DIR__ . '/../../resources/lang', lang_path('/vendor/trov'));

        $this->call('trov:eject-models');
        $this->call('trov:eject-resources');

        $this->info('Published Trov Resources.');

        $this->info('Trov is now installed.');
    }
}
