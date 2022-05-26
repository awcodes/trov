<?php

namespace Trov\Traits;

use App\Models\Linkable;

trait HasLinkable
{
    public function linkables()
    {
        return $this->morphMany(Linkable::class, 'linkable');
    }
}
