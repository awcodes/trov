<?php

namespace Trov\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Meta;

trait HasMeta
{
    protected static function bootHasMeta()
    {
        static::forceDeleted(function ($model) {
            $model->meta()->delete();
        });
    }

    public function meta(): MorphOne
    {
        return $this->morphOne(Meta::class, 'metaable');
    }
}
