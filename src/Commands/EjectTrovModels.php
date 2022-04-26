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

class EjectTrovModels extends Command
{
    use Concerns\CanManipulateFiles;

    public $signature = 'trov:eject-models';

    public $description = "Eject Trov Models into app for customization.";

    public function handle(): int
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

        return self::SUCCESS;
    }
}
