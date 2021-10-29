<?php


namespace App\Services\Station;


use App\DTO\StationDTO;
use App\Repository\Station\StationRepositoryInterface;
use App\Station;

class UpdateStationService implements UpdateStationServiceInterface
{
    /**
     * @var StationRepositoryInterface
     */
    private $stationRepository;

    public function __construct(StationRepositoryInterface $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    public function updateStation(int $stationId, StationDTO $stationDTO) : Station
    {
        $station = $this->stationRepository->getStation($stationId);

        $this->stationRepository->updateStation($stationDTO, $station);

        return $station;
    }
}
