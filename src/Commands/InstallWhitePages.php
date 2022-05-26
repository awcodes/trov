<?php

namespace Trov\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;

class InstallWhitePages extends Command
{
    use \Trov\Commands\Concerns\CanManipulateFiles;

    public $signature = 'trov:install-whitepages {--fresh}';

    public $description = "Install Trov White Pages into the app.";

    public function handle(): int
    {
        $this->alert('The Following operations will be performed.');

        $this->info('Publish White Pages migration');
        $this->warn('  - On fresh applications database will be migrated');
        $this->warn('  - You can also force this behavior by supplying the --fresh option');
        $this->info('Publish Filament Resources');

        $confirmed = $this->confirm('Do you wish to continue?', true);

        if ($this->CheckIfAlreadyInstalled() && !$this->option('fresh')) {
            $this->comment('Seems you have already installed the Trov White Pages!');
            $this->comment('You should run `trov-whitepages:install --fresh` instead to refresh the Trov White Pages tables and setup.');

            if ($this->confirm('Run `trov-whitepages:install --fresh` instead?', false)) {
                $this->install(true);
            }

            return self::INVALID;
        }

        if ($confirmed) {
            $this->install($this->option('fresh'));
        } else {
            $this->comment('`trov-whitepages:install` command was cancelled.');
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
        return collect(['white_pages']);
    }

    protected function install(bool $fresh = false)
    {
        $this->call('vendor:publish', [
            '--tag' => 'trov-whitepages-migrations',
        ]);

        if ($fresh) {
            try {
                Schema::disableForeignKeyConstraints();
                DB::table('migrations')->where('migration', 'like', '%_create_white_pages_table')->delete();
                $this->getTables()->each(fn ($table) => DB::statement('DROP TABLE IF EXISTS ' . $table));
                Schema::enableForeignKeyConstraints();
            } catch (\Throwable $e) {
                $this->info($e);
            }

            $this->call('migrate');
            $this->info('Database migrations freshed up.');
        } else {
            $this->call('migrate');
            $this->info('Database migrated.');
        }

        $baseDatabaseFactoriesPath = database_path('factories');
        (new Filesystem())->ensureDirectoryExists($baseDatabaseFactoriesPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/whitepages/database/factories', $baseDatabaseFactoriesPath);

        $this->ejectModels();
        $this->ejectResources();

        $this->info('Trov White Page is now installed.');

        return self::SUCCESS;
    }

    public function ejectModels()
    {
        $baseModelsPath = app_path((string) Str::of('Models')->replace('\\', '/'),);
        $whitePageModelsPath = app_path((string) Str::of('Models\\WhitePage.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$whitePageModelsPath])) {
            $confirmed = $this->confirm('White Page Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseModelsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/whitepages/models', $baseModelsPath);

        $this->info('Trov White Page Models have been published successfully!');
    }

    public function ejectResources()
    {
        $baseResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov')->replace('\\', '/'),);
        $whitePageResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\WhitePageResource.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$whitePageResourcePath])) {
            $confirmed = $this->confirm('Trov White Page Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseResourcePath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/whitepages/resources', $baseResourcePath);

        $this->info('Trov White Page Resources have been published successfully!');
    }
}
