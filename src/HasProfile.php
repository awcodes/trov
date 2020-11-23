<?php

namespace Trov;

use Illuminate\Support\Str;

trait HasProfile
{
    public function getRoleAttribute($value)
    {
        return Str::title($this->roles()->pluck('name')->first());
    }

    public function avatarUrl($size = 80)
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($this->email)));
        $url .= "?s={$size}&d=mp&r=pg";

        return $url;
    }
}
