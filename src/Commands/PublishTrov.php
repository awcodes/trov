<?php

namespace Trov\Commands;

use Illuminate\Filesystem\Filesystem;
use Trov\Commands\Concerns\CanManipulateFiles;

class PublishTrov extends Command
{
    use CanManipulateFiles;

    public $signature = 'trov:publish';

    public $description = 'Publish Trov\'s Resources.';

    public function handle(): int
    {
        $baseResourcePath = app_path((string) Str::of('Filament\\Resources\\')->replace('\\', '/'),);

        $resources = [
            'authors' => app_path((string) Str::of('Filament\\Resources\\AuthorResource.php')->replace('\\', '/'),);
            'discoveryArticles' => app_path((string) Str::of('Filament\\Resources\\DiscoveryAritcleResource.php')->replace('\\', '/'),);
            'discoveryTopics' => app_path((string) Str::of('Filament\\Resources\\DiscoveryTopicResource.php')->replace('\\', '/'),);
            'faqs' => app_path((string) Str::of('Filament\\Resources\\FaqResource.php')->replace('\\', '/'),);
            'landingPages' => app_path((string) Str::of('Filament\\Resources\\LandingPageResource.php')->replace('\\', '/'),);
            'linkSets' => app_path((string) Str::of('Filament\\Resources\\LinkSetResource.php')->replace('\\', '/'),);
            'media' => app_path((string) Str::of('Filament\\Resources\\MediaResource.php')->replace('\\', '/'),);
            'pages' => app_path((string) Str::of('Filament\\Resources\\PageResource.php')->replace('\\', '/'),);
            'posts' => app_path((string) Str::of('Filament\\Resources\\PostResource.php')->replace('\\', '/'),);
            'users' => app_path((string) Str::of('Filament\\Resources\\UserResource.php')->replace('\\', '/'),);
            'whitePages' => app_path((string) Str::of('Filament\\Resources\\WhitePageResource.php')->replace('\\', '/'),);
        ];

        foreach ($resources as $k => $v) {
            if ($this->checkForCollision([$v])) {
                $confirmed = $this->confirm($k . ' Resource already exists. Overwrite?', true);
                if (! $confirmed) {
                    unset($resources[$k]);
                }
            }
        }

        (new Filesystem())->ensureDirectoryExists($baseResourcePath);

        foreach ($resources as $k => $v) {
            (new Filesystem())->copyDirectory(__DIR__.'/../../stubs/resources/' . $k, $baseResourcePath);
        }

        $this->info('Trov\'s Resources have been published successfully.');

        return self::SUCCESS;
    }
}
