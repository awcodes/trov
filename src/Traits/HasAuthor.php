<?php

namespace Trov\Traits;

use Trov\Models\Author;

trait HasAuthor
{
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
