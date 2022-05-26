<?php

namespace Trov\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;

class InstallLinkables extends Command
{
    use \Trov\Commands\Concerns\CanManipulateFiles;

    public $signature = 'trov:install-linkables {--fresh}';

    public $description = "Install Trov Linkables into the app.";

    public function handle(): int
    {
        $this->alert('The Following operations will be performed.');

        $this->info('Publish Linkables migration');
        $this->warn('  - On fresh applications database will be migrated');
        $this->warn('  - You can also force this behavior by supplying the --fresh option');
        $this->info('Publish Filament Resources');

        $confirmed = $this->confirm('Do you wish to continue?', true);

        if ($this->CheckIfAlreadyInstalled() && !$this->option('fresh')) {
            $this->comment('Seems you have already installed the Trov Linkables!');
            $this->comment('You should run `trov-linkables:install --fresh` instead to refresh the Trov Linkables tables and setup.');

            if ($this->confirm('Run `trov-linkables:install --fresh` instead?', false)) {
                $this->install(true);
            }

            return self::INVALID;
        }

        if ($confirmed) {
            $this->install($this->option('fresh'));
        } else {
            $this->comment('`trov-linkables:install` command was cancelled.');
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
        return collect(['linkables']);
    }

    protected function install(bool $fresh = false)
    {
        $this->call('vendor:publish', [
            '--tag' => 'trov-linkables-migrations',
        ]);

        if ($fresh) {
            try {
                Schema::disableForeignKeyConstraints();
                DB::table('migrations')->where('migration', 'like', '%_create_linkables_table')->delete();
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

        $this->ejectModels();
        $this->ejectResources();

        $this->info('Trov Linkables is now installed.');

        return self::SUCCESS;
    }

    public function ejectModels()
    {
        $baseModelsPath = app_path((string) Str::of('Models')->replace('\\', '/'),);
        $linkableModelsPath = app_path((string) Str::of('Models\\Linkable.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$linkableModelsPath])) {
            $confirmed = $this->confirm('Linkables Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseModelsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/linkables/models', $baseModelsPath);

        $this->info('Trov Linkables Models have been published successfully!');
    }

    public function ejectResources()
    {
        $baseResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov')->replace('\\', '/'),);
        $linkablesResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\LinkableResource.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$linkablesResourcePath])) {
            $confirmed = $this->confirm('Trov Linkables Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseResourcePath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/linkables/resources', $baseResourcePath);

        $this->info('Trov Linkables Resources have been published successfully!');
    }
}
