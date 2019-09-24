<?php

namespace App\Rules;

use App\Services\CbrCurrencyService;
use Illuminate\Contracts\Validation\Rule;

class CurrencyCode implements Rule
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
        return array_key_exists($value, CbrCurrencyService::$currenciesIds);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.invalid_currency_code');
    }
}
