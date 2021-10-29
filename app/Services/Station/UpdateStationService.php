<?php


namespace App\Services\Station;


use App\DTO\StationDTO;
use App\Repository\Station\StationRepositoryInterface;
use App\Station;

class UpdateStationService implements UpdateStationServiceInterface
{
    public function __construct(private StationRepositoryInterface $stationRepository)
    {
    }

    public function updateStation(int $stationId, StationDTO $stationDTO) : Station
    {
        $station = $this->stationRepository->getStation($stationId);

        $this->stationRepository->updateStation($stationDTO, $station);

        return $station;
    }
}
