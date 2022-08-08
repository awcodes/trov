<?php

namespace Trov\Commands\Concerns;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

trait CanManipulateFiles
{
    protected function checkForCollision(array $paths): bool
    {
        foreach ($paths as $path) {
            if ($this->fileExists($path)) {
                return true;
            }
        }

        return false;
    }

    protected function fileExists(string $path): bool
    {
        $filesystem = new Filesystem();

        return $filesystem->exists($path);
    }
}
