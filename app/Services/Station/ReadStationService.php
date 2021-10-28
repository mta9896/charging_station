<?php


namespace App\Services\Station;


use App\DTO\StationFiltersDTO;
use App\Repository\Station\StationRepositoryInterface;
use App\Services\Station\StationFetch\StationFetchStrategy;
use App\Station;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
        /** @var StationFetchStrategy $stationStrategy */
        foreach (app()->tagged('stationFetch') as $stationStrategy) {
            if ($stationStrategy->shouldBeApplied($stationFiltersDTO)) {
                return $stationStrategy->fetchCollection($stationFiltersDTO);
            }
        }

        return $this->fetchAllStationsByDefault();
    }

    public function showSingleStation(int $stationId): Station
    {
        return $this->stationRepository->getStation($stationId);
    }

    private function fetchAllStationsByDefault() : Collection
    {
        return $this->stationRepository->getStationsList();
    }
}
