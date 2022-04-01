<?php

namespace Trov\Traits;

use Trov\Models\Media;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasFeaturedImage
{
    public function getFeaturedImageAttribute()
    {
        return $this->meta && $this->meta->ogImage ? $this->meta->ogImage : (object) config('trov.media.default_featured_image');
    }
}
