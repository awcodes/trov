<?php

namespace Trov\Commands;

use Filament\Facades\Filament;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Trov\Commands\Concerns\CanBackupAFile;
use Trov\Commands\Concerns\CanManipulateFiles;

class InstallTrov extends Command
{
    use CanBackupAFile, CanManipulateFiles;

    public function handle(): int
    {
        public $signature = 'trov:install {--F|fresh}';

        public $description = "Install Trov into your application.";

        $this->alert('This should not be performed on an existing Laravel Application.');

        $confirmed = $this->confirm('Do you wish to continue?', true);

        if ($this->checkIfAlreadyInstalled() && ! $this->option('fresh')) {
            $this->comment('Seems like you already installed Trov!');
            $this->comment('You should run `trov:install --fresh` instead to reinstall the package.');

            if ($this->confirm('Run `trov:install --fresh` instead?', false)) {
                $this->install(true);
            }

            return self::INVALID;
        }

        if ($confirmed) {
            $this->install($this->option('fresh'));
        } else {
            $this->comment('`trov:install` command cancelled.');
        }

        return self::SUCCESS;
    }

    protected function checkIfAlreadyInstalled(): bool
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
        return collect(['pages', 'metas', 'media']);
    }

    protected function install(bool $fresh = false)
    {
        $this->call('vendor:publish', [
            '--provider' => 'Trov\TrovServiceProvider'
        ]);

        $this->info('Trov config published.');

        if ($fresh) {
            try {
                Schema::disableForeignKeyConstraints();
                DB::table('migrations')->where('migration', 'like', '%_create_trov_tables_%')->delete();
                $this->getTables()->each(fn ($table) => DB::statement('DROP TABLE IF EXISTS ' . $table));
                Schema::enableForeignKeyConstraints();
            } catch(\Throwable $e) {
                $this->info($e);
            }

            $this->call('migrate');
            $this->info('Database migrations refreshed.');

            (new Filesystem())->ensureDirectoryExists();

            if ($this->ensureDirectoryExists(config_path('trov.php'), config_path('trov.php.bak'))) {
                $this->info('Trov Config backup created.');
            }

            if ($this->ensureDirectoryExists(config_path('filament.php'), config_path('filament.php.bak'))) {
                $this->info('Filament Config backup created.');
            }

            if ($this->ensureDirectoryExists(config_path('filament-breezy.php'), config_path('filament-breezy.php.bak'))) {
                $this->info('Filament Breezy Config backup created.');
            }

            if ($this->ensureDirectoryExists(config_path('filament-forms-tinyeditor.php'), config_path('filament-forms-tinyeditor.php.bak'))) {
                $this->info('Filament Forms TinyEditor Config backup created.');
            }

            if ($this->ensureDirectoryExists(config_path('filament-shield.php'), config_path('filament-shield.php.bak'))) {
                $this->info('Filament Shield Config backup created.');
            }

            (new Filesystem())->copy(__DIR__ . '/../../config/trov.php', config_path('trov.php'));
            (new Filesystem())->copy(__DIR__ . '/../../config/filament.php', config_path('filament.php'));
            (new Filesystem())->copy(__DIR__ . '/../../config/filament-breezy.php', config_path('filament-breezy.php'));
            (new Filesystem())->copy(__DIR__ . '/../../config/filament-forms-tinyeditor.php', config_path('filament-forms-tinyeditor.php'));
            (new Filesystem())->copy(__DIR__ . '/../../config/filament-shield.php', config_path('filament-shield.php'));
        } else {
            $this->call('migrate');
            $this->info('Database migrated.');
        }

        $this->call('trov:publish');

        $this->info('Published Trov\'s views & Resources.');

        $this->info('Trov installed successfully.');
    }
}