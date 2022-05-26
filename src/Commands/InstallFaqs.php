<?php

namespace Trov\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;

class InstallFaqs extends Command
{
    use \Trov\Commands\Concerns\CanManipulateFiles;

    public $signature = 'trov:install-faqs {--fresh}';

    public $description = "Install Trov FAQs into the app.";

    public function handle(): int
    {
        $this->alert('The Following operations will be performed.');

        $this->info('Publish FAQs migration');
        $this->warn('  - On fresh applications database will be migrated');
        $this->warn('  - You can also force this behavior by supplying the --fresh option');
        $this->info('Publish Filament Resources');

        $confirmed = $this->confirm('Do you wish to continue?', true);

        if ($this->CheckIfAlreadyInstalled() && !$this->option('fresh')) {
            $this->comment('Seems you have already installed the Trov FAQs!');
            $this->comment('You should run `trov-faqs:install --fresh` instead to refresh the Trov FAQs tables and setup.');

            if ($this->confirm('Run `trov-faqs:install --fresh` instead?', false)) {
                $this->install(true);
            }

            return self::INVALID;
        }

        if ($confirmed) {
            $this->install($this->option('fresh'));
        } else {
            $this->comment('`trov-faqs:install` command was cancelled.');
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
        return collect(['faqs']);
    }

    protected function install(bool $fresh = false)
    {
        $this->call('vendor:publish', [
            '--tag' => 'trov-faqs-migrations',
        ]);

        if ($fresh) {
            try {
                Schema::disableForeignKeyConstraints();
                DB::table('migrations')->where('migration', 'like', '%_create_faqs_table')->delete();
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
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/faqs/database/factories', $baseDatabaseFactoriesPath);

        $this->ejectModels();
        $this->ejectResources();

        $this->info('Trov FAQs is now installed.');

        return self::SUCCESS;
    }

    public function ejectModels()
    {
        $baseModelsPath = app_path((string) Str::of('Models')->replace('\\', '/'),);
        $faqModelsPath = app_path((string) Str::of('Models\\Faq.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$faqModelsPath])) {
            $confirmed = $this->confirm('FAQ Model already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseModelsPath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/faqs/models', $baseModelsPath);

        $this->info('Trov FAQs Models have been published successfully!');
    }

    public function ejectResources()
    {
        $baseResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov')->replace('\\', '/'),);
        $faqsResourcePath = app_path((string) Str::of('Filament\\Resources\\Trov\\FaqResource.php')->replace('\\', '/'),);

        if ($this->checkForCollision([$faqsResourcePath])) {
            $confirmed = $this->confirm('Trov FAQ Resource already exists. Overwrite?', true);
            if (!$confirmed) {
                return self::INVALID;
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseResourcePath);
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/faqs/resources', $baseResourcePath);

        $this->info('Trov FAQs Resources have been published successfully!');
    }
}
