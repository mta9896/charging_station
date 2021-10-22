<?php


namespace App\Http\Controllers;


use App\Company;
use App\Station;
use Illuminate\Http\Request;

class CompanyController
{
    public function index()
    {
        $companies = Company::with('parent')->get();

        return response()->json(['companies' => $companies]);
    }

    public function show(Company $company)
    {
        return response()->json(['company' => $company]);
    }

    public function create(Request $request)
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

    public function update(Company $company, Request $request)
    {
        $request->validate([
            'company.name' => 'required|string',
        ]);

        $company->update($request->get('company'));

        return response()->json(['company' => $company]);
    }

    public function delete(Company $company)
    {
        $company->delete();
    }

    public function getAllStationsByCompany(Company $company)
    {
        $companies = Company::descendantsAndSelf($company->id);
        $companyIds = $companies->pluck('id');

        $stations = Station::whereIn('company_id', $companyIds)->get();

        return response()->json(['stations' => $stations]);
    }

    private function assignParentToCompany(Company $company, int $parentId)
    {
        $parentCompany = Company::findOrFail($parentId);
        $parentCompany->children()->save($company);
    }
}
