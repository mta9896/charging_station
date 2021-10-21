<?php


namespace App\Http\Controllers\Station;


use App\Company;

class ListCompanyStationsController
{
    public function __invoke(Company $company)
    {
        // edit
        // pagination
        $stations = $company->stations()->get();

        return response()->json(['stations' => $stations]);
    }
}
