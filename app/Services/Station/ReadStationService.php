<?php


namespace App\Services\Station;


use App\DTO\StationFiltersDTO;
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

    public function listStations(StationFiltersDTO $stationFiltersDTO): Collection
    {
        return $this->stationRepository->getStationsList($stationFiltersDTO);
    }

    public function showSingleStation(int $stationId): Station
    {
        return $this->stationRepository->getStation($stationId);
    }
}
