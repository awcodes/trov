<?php

namespace Trov\Traits;

trait HasPublishedScope
{
    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPublished($query)
    {
        return $query->where('status', 'Published');
    }
}
