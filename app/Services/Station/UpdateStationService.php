<?php


namespace App\Services\Station;


use App\DTO\StationDTO;
use App\Repository\Company\CompanyRepositoryInterface;
use App\Repository\Station\StationRepositoryInterface;

class UpdateStationService implements UpdateStationServiceInterface
{
    /**
     * @var StationRepositoryInterface
     */
    private $stationRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository, StationRepositoryInterface $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    public function updateStation(int $stationId, StationDTO $stationDTO)
    {
        $station = $this->stationRepository->getStation($stationId);

        $this->stationRepository->updateStation($stationDTO, $station);

        return $station;
    }
}
