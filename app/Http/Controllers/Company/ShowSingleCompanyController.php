<?php


namespace App\Http\Controllers\Company;


use App\Company;

class ShowSingleCompanyController
{
    public function __invoke(Company $company)
    {
        return response()->json(['company' => $company]);
    }
}
