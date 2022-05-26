<?php

if (!function_exists('format_phone')) {
  function format_phone($value)
  {
    $value = preg_replace("/[^\d]/", "", $value);
    return '(' . substr($value, 0, 3) . ') ' . substr($value, 3, 3) . '-' . substr($value, 6);
  }
}

if (!function_exists('clean_phone')) {
  function clean_phone($value)
  {
    return preg_replace("/[^\d]/", "", $value);
  }
}

if (!function_exists('format_currency')) {
  function format_currency($value)
  {
    $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
    $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
    return $fmt->formatCurrency($value, "USD");
  }
}

if (!function_exists('format_us_number')) {
  function format_us_number($value)
  {
    $fmt = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
    $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
    return $fmt->format($value);
  }
}

if (!function_exists('format_with_article')) {
  function format_with_article($word)
  {
    return in_array(strtolower(substr($word, 0, 1)), ['a', 'e', 'i', 'o', 'u']) ? __('an ') : __('a ') . $word;
  }
}
