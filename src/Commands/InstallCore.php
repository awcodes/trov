<?php

namespace Trov\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;

class InstallCore extends Command
{
    use Concerns\CanManipulateFiles;
    use Concerns\CanBackupAFile;

    public $signature = 'trov:install-core {--fresh}';

    public $description = "Installs Trov CMS starter core.";

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

        $this->ejectModels();
        $this->ejectResources();
        $this->ejectFormComponents();

        $this->info('Trov is now installed.');
    }

    public function ejectModels()
    {
        $baseModelsPath = app_path((string) Str::of('Models')->replace('\\', '/'),);
        $pageModelsPath = app_path((string) Str::of('Models\\Page.php')->replace('\\', '/'),);
        $postModelsPath = app_path((string) Str::of('Models\\Post.php')->replace('\\', '/'),);
        $authorModelsPath = app_path((string) Str::of('Models\\Author.php')->replace('\\', '/'),);
        $metaModelsPath = app_path((string) Str::of('Models\\Meta.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$metaModelsPath])) {
            $confirmed = $this->confirm('Meta Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$pageModelsPath])) {
            $confirmed = $this->confirm('Page Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$postModelsPath])) {
            $confirmed = $this->confirm('Post Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$authorModelsPath])) {
            $confirmed = $this->confirm('Author Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseModelsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/models', $baseModelsPath);

        $this->info('Trov\'s Models have been published successfully!');
    }

    public function ejectResources()
    {
        $baseResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov')->replace('\\', '/'),);
        $pageResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\PageResource.php')->replace('\\', '/'),);
        $postResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\PostResource.php')->replace('\\', '/'),);
        $authorResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\AuthorResource.php')->replace('\\', '/'),);
        $userResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\UserResource.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$pageResourcePath])) {
            $confirmed = $this->confirm('Trov Page Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$postResourcePath])) {
            $confirmed = $this->confirm('Trov Post Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$authorResourcePath])) {
            $confirmed = $this->confirm('Trov Author Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$userResourcePath])) {
            $confirmed = $this->confirm('Trov User Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseResourcePath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/resources', $baseResourcePath);

        $this->info('Trov\'s Resources have been published successfully!');
    }

    public function ejectFormComponents()
    {
        $baseFormsPath = app_path((string) Str::of('Forms\\Trov')->replace('\\', '/'),);
        $baseComponentsPath = app_path((string) Str::of('View\\Components\\Trov')->replace('\\', '/'),);

        if ($this->checkForCollision([$baseFormsPath])) {
            $confirmed = $this->confirm('Form Components have already been ejected. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        if ($this->checkForCollision([$baseComponentsPath])) {
            $confirmed = $this->confirm('View Components have already been ejected. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseFormsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/forms', $baseFormsPath);

        (new Filesystem())->ensureDirectoryExists($baseComponentsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/view', $baseComponentsPath);

        $this->info('Trov\'s Form Components / Page Builder have been published successfully!');
    }
}
