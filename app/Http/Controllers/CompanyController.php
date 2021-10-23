<?php


namespace App\Http\Controllers;


use App\DTO\CompanyDTO;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Services\Company\CreateCompanyServiceInterface;
use App\Services\Company\DeleteCompanyService;
use App\Services\Company\ReadCompanyServiceInterface;
use App\Services\Company\UpdateCompanyServiceInterface;

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

    public function create(CreateCompanyRequest $request)
    {
        $companyDTO = new CompanyDTO(
            $request->input('company.name'),
            $request->input('company.parentId')
        );

        $company = $this->createCompanyService->createCompany($companyDTO);

        return new CompanyResource($company);
    }

    public function update(int $companyId, UpdateCompanyRequest $request)
    {
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
