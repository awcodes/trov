<?php

namespace Trov\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class Install extends Command
{
    use Concerns\CanManipulateFiles;
    use Concerns\CanBackupAFile;
    use Concerns\CanInstallPackage;

    public $signature = 'trov:install {--fresh}';

    public $description = "Installs Trov CMS starter core.";

    private $filesystem = null;

    public function handle(): int
    {
        if ($this->CheckIfAlreadyInstalled() && !$this->option('fresh')) {
            $this->warn('Trov Core already installed!');

            if ($this->confirm('Run `trov:install --fresh` instead?', false)) {
                $this->install(true);
            }

            return self::INVALID;
        }

        $this->install($this->option('fresh'));

        return self::SUCCESS;
    }

    protected function getTables(): Collection
    {
        return collect(['pages', 'posts', 'authors', 'metas', 'tags', 'taggables']);
    }

    protected function install(bool $fresh = false)
    {
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\Tags\TagsServiceProvider',
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'trov-migrations',
        ]);

        if ($fresh) {
            try {
                Schema::disableForeignKeyConstraints();
                $this->getTables()->each(fn ($table) => DB::table('migrations')->where('migration', 'like', '%_create_' . $table . '_table')->delete());
                $this->getTables()->each(fn ($table) => DB::statement('DROP TABLE IF EXISTS ' . $table));
                Schema::enableForeignKeyConstraints();
            } catch (\Throwable $e) {
                $this->info($e);
            }

            $this->call('migrate');

            File::ensureDirectoryExists(config_path());

            if ($this->isBackupPossible(
                config_path('trov.php'),
                config_path('trov.php.bak')
            )) {
                $this->info('Config backup created.');
            }

            $this->call('vendor:publish', ['--tag' => 'trov-config', '--force' => true]);
        } else {
            $this->call('migrate');
        }

        File::ensureDirectoryExists(lang_path());
        File::copyDirectory(__DIR__ . '/../../resources/lang', lang_path('/vendor/trov'));

        $this->info('Trov is now installed.');
    }
}
