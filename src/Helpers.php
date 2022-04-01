<?php

if (!function_exists('untrailingSlashIt')) {
    function untrailingSlashIt(string $string): string
    {
        return rtrim($string, '/\\');
    }
}

if (!function_exists('trailingSlashIt')) {
    function trailingSlashIt(string $string): string
    {
        if ($string != config('app.url')) {
            return untrailingSlashIt($string) . '/';
        }

        return $string;
    }
}

if (!function_exists('random_password')) {
    function randomPassword(): string
    {
        $random = str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        return substr($random, 0, 10);
    }
}
