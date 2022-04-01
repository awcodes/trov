<?php

namespace Trov\Traits;

use Trov\Models\LinkSet;

trait HasLinkSet
{
    public function linkSets()
    {
        return $this->morphMany(LinkSet::class, 'linkable');
    }
}
