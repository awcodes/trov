<?php

namespace Trov\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Trov\Models\Meta;

trait HasMeta
{
    protected static function booted()
    {
        parent::booted();

        static::deleted(function ($model) {
            $model->meta()->delete();
        });
    }

    public function meta(): MorphOne
    {
        return $this->morphOne(Meta::class, 'metaable');
    }
}
