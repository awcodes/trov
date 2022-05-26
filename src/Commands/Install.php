<?php

namespace Trov\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    use Concerns\CanManipulateFiles;
    use Concerns\CanBackupAFile;

    public $signature = 'trov:install {--fresh} {--module=}';

    public $description = "Installs Trov CMS starter.";

    public function handle(): int
    {
        match ($this->option('module')) {
            'faqs' => $this->call('trov:install-faqs', ['--fresh' => $this->option('fresh')]),
            'whitepages' => $this->call('trov:install-whitepages', ['--fresh' => $this->option('fresh')]),
            'discoveries' => $this->call('trov:install-discoveries', ['--fresh' => $this->option('fresh')]),
            'linkables' => $this->call('trov:install-linkables', ['--fresh' => $this->option('fresh')]),
            'airport' => $this->call('trov:install-airport', ['--fresh' => $this->option('fresh')]),
            default => $this->call('trov:install-core', ['--fresh' => $this->option('fresh')]),
        };

        return self::SUCCESS;
    }
}
