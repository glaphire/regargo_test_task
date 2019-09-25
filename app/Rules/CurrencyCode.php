<?php

namespace App\Rules;

use App\Services\CurrencyServiceInterface;
use Illuminate\Contracts\Validation\Rule;

class CurrencyCode implements Rule
{
    private $currencyService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(CurrencyServiceInterface $currencyService)
    {
        $this->currencyService = $currencyService;
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
        return in_array($value, $this->currencyService->getCurrencyCodes());
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
