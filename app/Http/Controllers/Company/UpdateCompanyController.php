<?php


namespace App\Http\Controllers\Company;

use App\Company;
use Illuminate\Http\Request;

class UpdateCompanyController
{
    public function __invoke(Company $company, Request $request)
    {
        $request->validate([
            'company.name' => 'required|string',
        ]);

        $company->update($request->get('company'));

        return response()->json(['company' => $company]);
    }
}
