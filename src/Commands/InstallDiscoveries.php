<?php

namespace Trov\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;

class InstallDiscoveries extends Command
{
    use \Trov\Commands\Concerns\CanManipulateFiles;

    public $signature = 'trov:install-discoveries {--fresh}';

    public $description = "Install Trov Discoveries into the app.";

    public function handle(): int
    {
        $this->alert('The Following operations will be performed.');

        $this->info('Publish Discoveries migration');
        $this->warn('  - On fresh applications database will be migrated');
        $this->warn('  - You can also force this behavior by supplying the --fresh option');
        $this->info('Publish Filament Resources');

        $confirmed = $this->confirm('Do you wish to continue?', true);

        if ($this->CheckIfAlreadyInstalled() && !$this->option('fresh')) {
            $this->comment('Seems you have already installed the Trov Discoveries!');
            $this->comment('You should run `trov-discoveries:install --fresh` instead to refresh the Trov Discoveries tables and setup.');

            if ($this->confirm('Run `trov-discoveries:install --fresh` instead?', false)) {
                $this->install(true);
            }

            return self::INVALID;
        }

        if ($confirmed) {
            $this->install($this->option('fresh'));
        } else {
            $this->comment('`trov-discoveries:install` command was cancelled.');
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
        return collect(['discovery_topics', 'discovery_articles']);
    }

    protected function install(bool $fresh = false)
    {
        $this->call('vendor:publish', [
            '--tag' => 'trov-discoveries-migrations',
        ]);

        if ($fresh) {
            try {
                Schema::disableForeignKeyConstraints();
                DB::table('migrations')->where('migration', 'like', '%_create_discoveries_tables')->delete();
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
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/discoveries/database/factories', $baseDatabaseFactoriesPath);

        $this->ejectModels();
        $this->ejectResources();
        $this->ejectFormComponents();

        $this->info('Trov Discoveries is now installed.');

        return self::SUCCESS;
    }

    public function ejectModels()
    {
        $baseModelsPath = app_path((string) Str::of('Models')->replace('\\', '/'),);
        $topicModelsPath = app_path((string) Str::of('Models\\DiscoveryTopic.php')->replace('\\', '/'),);
        $articleModelsPath = app_path((string) Str::of('Models\\DiscoveryArticle.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$topicModelsPath])) {
            $confirmed = $this->confirm('Discovery Topic Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$articleModelsPath])) {
            $confirmed = $this->confirm('Discovery Article Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseModelsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/discoveries/models', $baseModelsPath);

        $this->info('Trov Discoveries Models have been published successfully!');
    }

    public function ejectResources()
    {
        $baseResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov')->replace('\\', '/'),);
        $topicResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\DiscoveryTopicResource.php')->replace('\\', '/'),);
        $articleResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\DiscoveryArticleResource.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$topicResourcePath])) {
            $confirmed = $this->confirm('Trov Discovery Topic Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$articleResourcePath])) {
            $confirmed = $this->confirm('Trov Discovery Article Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseResourcePath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/discoveries/resources', $baseResourcePath);

        $this->info('Trov Discoveries Resources have been published successfully!');
    }

    public function ejectFormComponents()
    {
        $baseFormsPath = app_path((string) Str::of('Forms\\Trov\\Blocks')->replace('\\', '/'),);
        $baseComponentsPath = app_path((string) Str::of('View\\Components\\Trov\\Blocks')->replace('\\', '/'),);
        $baseResourcesPath = resource_path((string) Str::of('views\\vendor\\trov\\components\\blocks')->replace('\\', '/'),);

        $blockPath = app_path((string) Str::of('Forms\\Trov\\Blocks\\Infographic.php')->replace('\\', '/'),);
        $componentPath = app_path((string) Str::of('View\\Components\\Trov\\Blocks\\Infographic.php')->replace('\\', '/'),);
        $resourcesPath = resource_path((string) Str::of('views\\vendor\\trov\\components\\blocks\\infographic.blade.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$blockPath])) {
            $confirmed = $this->confirm('Trov Discoveries Form Components have already been ejected. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$componentPath])) {
            $confirmed = $this->confirm('Trov Discoveries View Components have already been ejected. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$resourcesPath])) {
            $confirmed = $this->confirm('Trov Discoveries Resources Components have already been ejected. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseFormsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/discoveries/forms', $baseFormsPath);

        (new Filesystem())->ensureDirectoryExists($baseComponentsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/discoveries/view', $baseComponentsPath);

        (new Filesystem())->ensureDirectoryExists($baseResourcesPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/discoveries/views', $baseResourcesPath);

        $this->info('Trov Discoveries Form Components / Views have been published successfully!');
    }
}
