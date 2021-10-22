<?php


namespace App\Services\Station;


use App\DTO\StationDTO;
use App\Repository\Company\CompanyRepositoryInterface;
use App\Repository\Station\StationRepositoryInterface;
use App\Station;

class CreateStationService implements CreateStationServiceInterface
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    /**
     * @var StationRepositoryInterface
     */
    private $stationRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository, StationRepositoryInterface $stationRepository)
    {
        $this->stationRepository = $stationRepository;
        $this->companyRepository = $companyRepository;
    }


    public function createStation(StationDTO $stationDTO): Station
    {
        $company = $this->companyRepository->getCompany($stationDTO->getCompanyId());

        $station = $this->stationRepository->createStation($stationDTO, $company);

        return $station;
    }
}
