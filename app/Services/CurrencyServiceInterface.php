<?php

namespace App\Services;

interface CurrencyServiceInterface
{
    public function getCurrencyCodes();

    public function getCurrencyValueByDate(string $currencyCode, string $date);
}
