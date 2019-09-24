<?php


namespace App\Http\Controllers;


use App\Rules\CurrencyCode;
use App\Rules\OgrnFormula;
use App\Services\CbrCurrencyService;
use Illuminate\Http\Request;

class OgrnController extends Controller
{
    public function showValidationForm()
    {
        return view('ogrn.validation_form');
    }

    public function validateOgrn(Request $request)
    {
        $request->validate([
            'ogrn_number' => [
                'required', 'numeric', 'digits:13', new OgrnFormula()
            ]
        ]);

        return response()->json(['is_correct' => true]);
    }

    public function showCurrencyForm(Request $request)
    {
        return view('ogrn.currency_form', [
            'ogrn_number' => $request->input('ogrn_number'),
        ]);
    }

    public function getCurrencyByDate(Request $request, CbrCurrencyService $cbrService)
    {
        $currency = $request->get('currency');
        $date = $request->get('date');

        $request->validate([
            'currency' => ['required', 'string', new CurrencyCode()],
            'date' => ['required', 'string', 'date_format:d/m/Y']
            ]);

        try {
            $currencyValue = $cbrService->getCurrencyValueByDate($currency, $date);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected response from third party server'], 500);
        }

        if ($currencyValue) {
            return response()->json(['currency' => $currencyValue]);
        } else {
            return response()->json(['error' => 'Couldn\'t get currency value'], 500);
        }
    }
}
