<?php

namespace Trov\Commands;

use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class EjectTrovResources extends Command
{
    use Concerns\CanManipulateFiles;

    public $signature = 'trov:eject-resources';

    public $description = "Eject Trov Resources into app for customization.";

    public function handle(): int
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

        return self::SUCCESS;
    }
}
