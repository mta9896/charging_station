<?php


namespace App\Services\Station;


use App\Repository\Company\CompanyRepositoryInterface;
use App\Repository\Station\StationRepositoryInterface;
use Illuminate\Support\Collection;

class StationsInCompanyTreeService implements StationsInCompanyTreeServiceInterface
{
    /**
     * @var StationRepositoryInterface
     */
    private $stationRepository;

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    public function __construct(StationRepositoryInterface $stationRepository, CompanyRepositoryInterface $companyRepository)
    {
        $this->stationRepository = $stationRepository;
        $this->companyRepository = $companyRepository;
    }

    public function getAllCompanyStations(int $companyId) : Collection
    {
        $company = $this->companyRepository->getCompany($companyId);
        $companyDescendants = $this->companyRepository->getCompanyDescendantsAndSelf($company);
        $companyIds = $companyDescendants->pluck('id');

        $stations = $this->stationRepository->getStationsByCompanyIds($companyIds);

        return $stations;
    }
}
