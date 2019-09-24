<?php


namespace App\Http\Controllers;


class OgrnController extends Controller
{
    public function validateOgrn()
    {
        return view('ogrn.validation_form');
    }
}