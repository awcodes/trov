<?php

namespace Trov\Traits;

use App\Models\Author;

trait HasAuthor
{
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
