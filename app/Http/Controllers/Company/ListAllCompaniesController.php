<?php


namespace App\Http\Controllers\Company;


use App\Company;

class ListAllCompaniesController
{
    public function __invoke()
    {
        $companies = Company::with('parent')->get();

        return response()->json(['companies' => $companies]);
    }
}
