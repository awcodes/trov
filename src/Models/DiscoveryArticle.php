<?php

namespace Trov\Models;

use Trov\Models\Media;
use Trov\Models\Author;
use Trov\Traits\HasMeta;
use Trov\Traits\HasAuthor;
use Trov\Traits\HasLinkSet;
use Trov\Traits\IsSluggable;
use Trov\Models\DiscoveryTopic;
use Trov\Traits\HasFeaturedImage;
use Trov\Traits\HasPublishedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscoveryArticle extends Model
{
    use HasPublishedScope;
    use IsSluggable;
    use HasFactory;
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
        'published_at' => 'datetime',
        'content' => 'array',
    ];

    protected $with = [
        'meta',
    ];

    public function getBasePath()
    {
        return '/discover/articles';
    }

    public function getPublicUrl()
    {
        return url()->to($this->getBasePath() . '/' . $this->slug . '/');
    }

    public function topic()
    {
        return $this->belongsTo(DiscoveryTopic::class, 'discovery_topic_id', 'id');
    }
}
