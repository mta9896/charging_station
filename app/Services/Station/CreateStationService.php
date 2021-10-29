<?php


namespace App\Services\Station;


use App\DTO\StationDTO;
use App\Repository\Company\CompanyRepositoryInterface;
use App\Repository\Station\StationRepositoryInterface;
use App\Station;

class CreateStationService implements CreateStationServiceInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private StationRepositoryInterface $stationRepository)
    {
    }


    public function createStation(StationDTO $stationDTO): Station
    {
        $company = $this->companyRepository->getCompany($stationDTO->getCompanyId());

        $station = $this->stationRepository->createStation($stationDTO, $company);

        return $station;
    }
}
