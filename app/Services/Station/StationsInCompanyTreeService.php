<?php


namespace App\Services\Station;


use App\Repository\Company\CompanyRepositoryInterface;
use App\Repository\Station\StationRepositoryInterface;
use Illuminate\Support\Collection;

class StationsInCompanyTreeService implements StationsInCompanyTreeServiceInterface
{
    public function __construct(
        private StationRepositoryInterface $stationRepository,
        private CompanyRepositoryInterface $companyRepository)
    {
    }

    public function getAllCompanyStations(int $companyId) : Collection
    {
        $company = $this->companyRepository->getCompany($companyId);
        $companyDescendantsIds = $this->companyRepository->getCompanyDescendantsAndSelfIds($company);

        $stations = $this->stationRepository->getStationsByCompanyIds($companyDescendantsIds);

        return $stations;
    }
}
