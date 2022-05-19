<?php

namespace App\Models;

use Trov\Traits\HasMeta;
use Trov\Traits\IsSluggable;
use Trov\Traits\HasPublishedScope;
use Trov\Traits\HasFeaturedImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    use HasPublishedScope;
    use IsSluggable;
    use HasMeta;
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
        'hero' => 'array',
        'content' => 'array',
        'front_page' => 'boolean',
    ];

    protected $with = [
        'meta',
    ];

    protected static function booted()
    {
        static::creating(function ($page) {
            if ($page->front_page) {
                $oldFrontPage = Page::where('front_page', true)->first();
                if ($oldFrontPage) {
                    $oldFrontPage->update([
                        'front_page' => false
                    ]);
                }

                $page->status = 'published';
                $page->layout = 'full';
            }
        });

        static::updating(function ($page) {
            if ($page->front_page) {
                $oldFrontPage = Page::where('front_page', true)->first();
                if ($oldFrontPage && $oldFrontPage->id !== $page->id) {
                    $oldFrontPage->update([
                        'front_page' => false
                    ]);
                }

                $page->status = 'published';
                $page->layout = 'full';
            }
        });
    }

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
        return url()->to($this->getBasePath() . $this->slug . '/');
    }
}
