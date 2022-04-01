<?php

namespace Trov\Observers;

use Trov\Models\Page;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PageObserver
{
    /**
     * Handle the Page "creating" event.
     *
     * @param  \Trov\Models\Page  $page
     * @return void
     */
    public function creating(Page $page)
    {
        if ($page->front_page) {
            $oldFrontPage = Page::where('front_page', true)->first();
            if ($oldFrontPage) {
                $oldFrontPage->update([
                    'front_page' => false
                ]);
            }

            $page->status = 'published';
            $page->layout = 'full';
        }
    }

    /**
     * Handle the Page "updating" event.
     *
     * @param  \Trov\Models\Page  $page
     * @return void
     */
    public function updating(Page $page)
    {
        if ($page->front_page) {
            $oldFrontPage = Page::where('front_page', true)->first();
            if ($oldFrontPage) {
                $oldFrontPage->update([
                    'front_page' => false
                ]);
            }

            $page->status = 'published';
            $page->layout = 'full';
        }
    }
}
