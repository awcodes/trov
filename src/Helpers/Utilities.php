<?php

use Spatie\Ray\Settings\Settings;
use Illuminate\Support\Facades\Route;

if (!function_exists('settings')) {
  function settings($key = null, $default = null)
  {
    if ($key === null) {
      return app(App\Utils\Settings::class);
    }

    return app(App\Utils\Settings::class)->get($key, $default);
  }
}

if (!function_exists('checked')) {
  function checked($value, $test)
  {
    return $value === $test ? 'checked' : '';
  }
}

if (!function_exists('selected')) {
  function selected($value, $test)
  {
    return $value === $test ? 'selected' : '';
  }
}

if (!function_exists('random_password')) {
  function random_password(): string
  {
    $random = str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
    return substr($random, 0, 10);
  }
}

if (!function_exists('untrailing_slash_it')) {
  function untrailing_slash_it(string $string): string
  {
    return rtrim($string, '/\\');
  }
}

if (!function_exists('trailing_slash_it')) {
  function trailing_slash_it(string $string): string
  {
    if ($string != config('app.url')) {
      return untrailing_slash_it($string) . '/';
    }

    return $string;
  }
}

if (!function_exists('active_route')) {
  function active_route(string $route, $active = true, $default = false)
  {
    if (url()->current() == $route) {
      return $active;
    }

    return $default;
  }
}
