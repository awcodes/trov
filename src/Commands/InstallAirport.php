<?php

namespace Trov\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;

class InstallAirport extends Command
{
    use \Trov\Commands\Concerns\CanManipulateFiles;

    public $signature = 'trov:install-airport {--fresh}';

    public $description = "Install Trov Airport into the app.";

    public function handle(): int
    {
        $this->alert('The Following operations will be performed.');

        $this->info('Publish Airport migration');
        $this->warn('  - On fresh applications database will be migrated');
        $this->warn('  - You can also force this behavior by supplying the --fresh option');
        $this->info('Publish Filament Resources');

        $confirmed = $this->confirm('Do you wish to continue?', true);

        if ($this->CheckIfAlreadyInstalled() && !$this->option('fresh')) {
            $this->comment('Seems you have already installed the Trov Airport!');
            $this->comment('You should run `trov:install-airport --fresh` instead to refresh the Trov Airport tables and setup.');

            if ($this->confirm('Run `trov:install-airport --fresh` instead?', false)) {
                $this->install(true);
            }

            return self::INVALID;
        }

        if ($confirmed) {
            $this->install($this->option('fresh'));
        } else {
            $this->comment('`trov:install-airport` command was cancelled.');
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
        return collect(['runways']);
    }

    protected function install(bool $fresh = false)
    {
        $this->call('vendor:publish', [
            '--tag' => 'trov-airport-migrations',
        ]);

        if ($fresh) {
            try {
                Schema::disableForeignKeyConstraints();
                DB::table('migrations')->where('migration', 'like', '%_create_runways_table')->delete();
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
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/airport/database/factories', $baseDatabaseFactoriesPath);

        $this->ejectModels();
        $this->ejectResources();

        $this->info('Trov Airport is now installed.');

        return self::SUCCESS;
    }

    public function ejectModels()
    {
        $baseModelsPath = app_path((string) Str::of('Models')->replace('\\', '/'),);
        $airportModelsPath = app_path((string) Str::of('Models\\Runway.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$airportModelsPath])) {
            $confirmed = $this->confirm('Airport Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseModelsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/airport/models', $baseModelsPath);

        $this->info('Trov Airport Models have been published successfully!');
    }

    public function ejectResources()
    {
        $baseResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov')->replace('\\', '/'),);
        $airportResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\AirportResource.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$airportResourcePath])) {
            $confirmed = $this->confirm('Trov Airport Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseResourcePath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/airport/resources', $baseResourcePath);

        $this->info('Trov Airport Resources have been published successfully!');
    }
}
