<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Trov\Traits\HasMeta;
use Trov\Traits\HasAuthor;
use Trov\Traits\IsSluggable;
use Trov\Traits\HasFeaturedImage;
use Trov\Traits\HasPublishedScope;
use Trov\Linkables\Traits\HasLinkSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasPublishedScope;
    use IsSluggable;
    use HasFactory;
    use HasTags;
    use HasMeta;
    use HasAuthor;
    use SoftDeletes;
    use HasFeaturedImage;
    use HasLinkSet;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'status',
        'author_id',
        'content',
        'published_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'indexable' => 'boolean',
        'published_at' => 'date',
        'content' => 'array',
    ];

    protected $with = [
        'meta',
    ];

    public function getBasePath()
    {
        return '/posts';
    }

    public function getPublicUrl()
    {
        return url()->to($this->getBasePath() . '/' . $this->slug . '/');
    }
}
