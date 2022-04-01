<?php

namespace Trov\Rules;

use Illuminate\Contracts\Validation\Rule;

class TmxVehicle implements Rule
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
        return preg_match('/^[0-9]{4}\s[a-zA-Z0-9-]*\s[a-zA-Z0-9-]*/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'For a more accurate estimate please provide the YEAR MAKE and MODEL of your vehicle.';
    }
}
