<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OgrnFormula implements Rule
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
        $value = (string)$value;

        return $this->validateLastNumber($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid OGRN last number.';
    }

    /**
     * Validates last number by OGRN formula
     *
     * @param string $ogrn
     * @link https://github.com/Kholenkov/php-data-validation/blob/master/src/DataValidation.php#L160
     */
    private function validateLastNumber(string $ogrn) {

        if (strlen($ogrn) != 13 ) {
            return false;
        }

        $n13 = (int)substr(bcsub(substr($ogrn, 0, -1), bcmul(bcdiv(substr($ogrn, 0, -1), '11', 0), '11')), -1);

        if ($n13 !== (int) $ogrn{12}) {
            return false;
        }

        return true;
    }
}
