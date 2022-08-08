<?php

namespace Trov\Traits;

use Trov\Models\Linkable;

trait HasLinkable
{
    public function linkables()
    {
        return $this->morphMany(Linkable::class, 'linkable');
    }
}
