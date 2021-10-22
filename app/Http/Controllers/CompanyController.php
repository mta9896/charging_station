<?php


namespace App\Http\Controllers;


use App\Company;
use App\DTO\CompanyDTO;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Services\Company\CreateCompanyServiceInterface;
use App\Services\Company\ReadCompanyServiceInterface;
use App\Station;
use Illuminate\Http\Request;

class CompanyController
{
    /**
     * @var ReadCompanyServiceInterface
     */
    private $readCompanyService;

    /**
     * @var CreateCompanyServiceInterface
     */
    private $createCompanyService;

    public function __construct(ReadCompanyServiceInterface $readCompanyService, CreateCompanyServiceInterface $createCompanyService)
    {
        $this->readCompanyService = $readCompanyService;
        $this->createCompanyService = $createCompanyService;
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

        $companyDTO = new CompanyDTO(
            $request->input('company.name'),
            $request->input('company.parentId')
        );

        $company = $this->createCompanyService->createCompany($companyDTO);

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
