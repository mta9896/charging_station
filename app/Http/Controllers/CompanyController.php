<?php


namespace App\Http\Controllers;


use App\Company;
use App\DTO\CompanyDTO;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Services\Company\CreateCompanyServiceInterface;
use App\Services\Company\DeleteCompanyService;
use App\Services\Company\ReadCompanyServiceInterface;
use App\Services\Company\UpdateCompanyServiceInterface;
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

    /**
     * @var UpdateCompanyServiceInterface
     */
    private $updateCompanyService;

    /**
     * @var DeleteCompanyService
     */
    private $deleteCompanyService;

    public function __construct(ReadCompanyServiceInterface $readCompanyService, CreateCompanyServiceInterface $createCompanyService, UpdateCompanyServiceInterface $updateCompanyService, DeleteCompanyService $deleteCompanyService)
    {
        $this->readCompanyService = $readCompanyService;
        $this->createCompanyService = $createCompanyService;
        $this->updateCompanyService = $updateCompanyService;
        $this->deleteCompanyService = $deleteCompanyService;
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

    public function update(int $companyId, Request $request)
    {
        $request->validate([
            'company.name' => 'required|string',
        ]);

        $companyDTO = new CompanyDTO(
            $request->input('company.name')
        );

        $company = $this->updateCompanyService->updateCompany($companyDTO, $companyId);

        return new CompanyResource($company);
    }

    public function delete(int $companyId)
    {
        $this->deleteCompanyService->deleteCompany($companyId);
    }
}
