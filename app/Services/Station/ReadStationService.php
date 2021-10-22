<?php


namespace App\Services\Station;


use App\Repository\Station\StationRepositoryInterface;
use App\Station;
use Illuminate\Support\Collection;

class ReadStationService implements ReadStationServiceInterface
{
    /**
     * @var StationRepositoryInterface
     */
    private $stationRepository;

    public function __construct(StationRepositoryInterface $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    public function listStations(): Collection
    {
        return $this->stationRepository->getStationsList();
    }

    public function showSingleStation(int $stationId): Station
    {
        return $this->stationRepository->getStation($stationId);
    }
}
