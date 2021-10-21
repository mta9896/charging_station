<?php


namespace App\Http\Controllers\Company;


use App\Company;
use Illuminate\Http\Request;

class CreateCompanyController
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'company.name' => 'required|string',
            'company.parentId' => 'nullable|int'
        ]);

        $company = Company::create([
            'name' => $request->input('company.name')
        ]);

        if (!empty($request->input('company.parentId'))) {
            $this->assignParentToCompany($company, $request->input('company.parentId'));
        }

        return response()->json(['company' => $company]);
    }

    private function assignParentToCompany(Company $company, int $parentId)
    {
        $parentCompany = Company::findOrFail($parentId);
        $parentCompany->children()->save($company);
    }
}
