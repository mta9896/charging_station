<?php


namespace App\Http\Controllers;


use App\DTO\CompanyDTO;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Station\StationCollection;
use App\Services\Company\CreateCompanyServiceInterface;
use App\Services\Company\DeleteCompanyService;
use App\Services\Company\ReadCompanyServiceInterface;
use App\Services\Company\UpdateCompanyServiceInterface;
use App\Services\Station\StationsInCompanyTreeServiceInterface;
use Illuminate\Http\Response;

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

    /**
     * @var StationsInCompanyTreeServiceInterface
     */
    private $stationsInCompanyTreeService;


    public function __construct(ReadCompanyServiceInterface $readCompanyService, CreateCompanyServiceInterface $createCompanyService, UpdateCompanyServiceInterface $updateCompanyService, DeleteCompanyService $deleteCompanyService, StationsInCompanyTreeServiceInterface $stationsInCompanyTreeService)
    {
        $this->readCompanyService = $readCompanyService;
        $this->createCompanyService = $createCompanyService;
        $this->updateCompanyService = $updateCompanyService;
        $this->deleteCompanyService = $deleteCompanyService;
        $this->stationsInCompanyTreeService = $stationsInCompanyTreeService;
    }

    public function index() : CompanyCollection
    {
        $companies = $this->readCompanyService->listCompanies();

        return new CompanyCollection($companies);
    }

    public function show(int $companyId) : CompanyResource
    {
        $company = $this->readCompanyService->showSingleCompany($companyId);

        return new CompanyResource($company);
    }

    public function create(CreateCompanyRequest $request) : CompanyResource
    {
        $companyDTO = new CompanyDTO(
            $request->input('company.name'),
            $request->input('company.parentId')
        );

        $company = $this->createCompanyService->createCompany($companyDTO);

        return new CompanyResource($company);
    }

    public function update(int $companyId, UpdateCompanyRequest $request) : CompanyResource
    {
        $companyDTO = new CompanyDTO(
            $request->input('company.name')
        );

        $company = $this->updateCompanyService->updateCompany($companyDTO, $companyId);

        return new CompanyResource($company);
    }

    public function delete(int $companyId) : Response
    {
        $this->deleteCompanyService->deleteCompany($companyId);

        return new Response('', 204);
    }

    public function getStationsByCompany(int $companyId) : StationCollection
    {
        $stations = $this->stationsInCompanyTreeService->getAllCompanyStations($companyId);

        return new StationCollection($stations);
    }
}
