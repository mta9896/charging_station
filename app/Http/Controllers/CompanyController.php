<?php


namespace App\Http\Controllers;


use App\Company;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Services\Company\ReadCompanyServiceInterface;
use App\Station;
use Illuminate\Http\Request;

class CompanyController
{
    /**
     * @var ReadCompanyServiceInterface
     */
    private $readCompanyService;

    public function __construct(ReadCompanyServiceInterface $readCompanyService)
    {
        $this->readCompanyService = $readCompanyService;
    }

    public function index()
    {
        $companies = $this->readCompanyService->listCompanies();

        return new CompanyCollection($companies);
    }

    public function show(int $companyId)
    {
        $company = $this->readCompanyService->showSingleCompany($companyId);

        return new CompanyResource($company);
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

        return new CompanyResource($company);
    }

    public function update(Company $company, Request $request)
    {
        $request->validate([
            'company.name' => 'required|string',
        ]);

        $company->update($request->get('company'));

        return new CompanyResource($company);
    }

    public function delete(Company $company)
    {
        $company->delete();
    }

    private function assignParentToCompany(Company $company, int $parentId)
    {
        $parentCompany = Company::findOrFail($parentId);
        $parentCompany->children()->save($company);
    }
}
