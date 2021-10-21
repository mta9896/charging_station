<?php


namespace App\Http\Controllers\Company;


use App\Company;

class DeleteCompanyController
{
    public function __invoke(Company $company)
    {
        $company->delete();
    }
}
