<?php

namespace App\Models;

use App\Models\Media;
use App\Models\Author;
use Spatie\Tags\HasTags;
use App\Traits\HasMeta;
use App\Traits\HasAuthor;
use App\Traits\HasLinkSet;
use App\Traits\IsSluggable;
use App\Traits\HasFeaturedImage;
use App\Traits\HasPublishedScope;
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
