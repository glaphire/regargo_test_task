<?php


namespace App\Http\Controllers;


use App\Rules\OgrnFormula;
use Illuminate\Http\Request;

class OgrnController extends Controller
{
    public function showValidationForm()
    {
        return view('ogrn.validation_form');
    }

    public function validateOgrn(Request $request)
    {
        $validationResult = $request->validate([
            'ogrn_number' => [
                'required', 'numeric', 'digits:13', new OgrnFormula()
            ]
        ]);

        if ($validationResult) {
            return response()->json([
                'is_correct' => true,
            ]);
        }

        return response()->json(['is_correct' => false], 422);
    }
}
