<?php

namespace App\Http\Controllers;

use App\Rules\OgrnFormula;
use App\Rules\CurrencyCode;
use Illuminate\Http\Request;
use App\Services\CurrencyServiceInterface;

class OgrnController extends Controller
{
    private $currencyService;

    public function __construct(CurrencyServiceInterface $cbrCurrencyService)
    {
        $this->currencyService = $cbrCurrencyService;
    }

    public function showValidationForm()
    {
        return view('ogrn.validation_form');
    }

    public function validateOgrn(Request $request)
    {
        $request->validate([
            'ogrn_number' => [
                'required', 'numeric', 'digits:13', new OgrnFormula(),
            ],
        ]);

        return response()->json(['is_correct' => true]);
    }

    public function showCurrencyForm(Request $request)
    {
        return view('ogrn.currency_form', [
            'ogrn_number' => $request->input('ogrn_number'),
            'currency_codes' => $this->currencyService->getCurrencyCodes(),
        ]);
    }

    public function getCurrencyByDate(Request $request)
    {
        $currency = $request->get('currency');
        $date = $request->get('date');

        $request->validate([
            'currency' => ['required', 'string', new CurrencyCode($this->currencyService)],
            'date' => ['required', 'string', 'date_format:d/m/Y'],
        ]);

        try {
            $currencyValue = $this->currencyService->getCurrencyValueByDate($currency, $date);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected response from third party server'], 500);
        }

        if (!$currencyValue) {
            return response()->json(['error' => 'Couldn\'t get currency value'], 500);
        }

        return response()->json(['currency' => $currencyValue]);
    }
}
