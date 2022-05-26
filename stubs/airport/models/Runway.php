<?php

namespace App\Models;

use Trov\Traits\IsSluggable;
use Trov\Traits\HasPublishedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Runway extends Model
{
    use HasFactory;
    use HasPublishedScope;
    use IsSluggable;
    use SoftDeletes;

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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'has_chat' => 'boolean',
        'content' => 'array',
    ];

    public function getBasePath()
    {
        return '/loans';
    }

    public function getPublicUrl()
    {
        return url()->to($this->getBasePath() . '/' . $this->slug . '/');
    }
}
