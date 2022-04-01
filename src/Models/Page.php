<?php

namespace Trov\Models;

use Trov\Traits\HasMeta;
use Trov\Traits\HasLinkSet;
use Trov\Traits\IsSluggable;
use Trov\Traits\HasPublishedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Trov\Traits\HasFeaturedImage;

class Page extends Model
{
    use HasFactory;
    use HasPublishedScope;
    use IsSluggable;
    use HasMeta;
    use HasLinkSet;
    use SoftDeletes;
    use HasFeaturedImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'status',
        'content',
        'has_chat',
        'layout',
        'front_page',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'has_chat' => 'boolean',
        'content' => 'array',
        'front_page' => 'boolean',
    ];

    protected $with = [
        'meta',
    ];

    public function scopeIsHomePage($query)
    {
        return $query->where('front_page', true)->first();
    }

    public function getBasePath()
    {
        return '/';
    }

    public function getPublicUrl()
    {
        return url()->to($this->getBasePath() . '/' . $this->slug . '/');
    }
}
