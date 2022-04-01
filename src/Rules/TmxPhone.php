<?php

namespace Trov\Rules;

use Illuminate\Contracts\Validation\Rule;

class TmxPhone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^\(?((?!(111|222|333|444|555|666|777|888|999|123|911))[2-9][0-9]{2})\)?[-. ]?((?!(555|.11))[2-9][0-9]{2})[-. ]?([0-9]{4})$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Invalid Phone Number.');
    }
}
