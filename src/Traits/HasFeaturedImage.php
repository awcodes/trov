<?php

namespace Trov\Traits;

use FilamentCurator\Models\Media;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasFeaturedImage
{
    public function getFeaturedImageAttribute()
    {
        return $this->meta && $this->meta->ogImage ? $this->meta->ogImage : (object) config('trov.default_featured_image');
    }
}
