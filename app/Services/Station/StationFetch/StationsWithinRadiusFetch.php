<?php


namespace App\Services\Station\StationFetch;


use App\DTO\StationFiltersDTO;
use App\Repository\Station\StationRepositoryInterface;
use Illuminate\Support\Collection;

class StationsWithinRadiusFetch implements StationFetchStrategyInterface
{
    /**
     * @var StationRepositoryInterface
     */
    private $stationRepository;

    public function __construct(StationRepositoryInterface $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    public function shouldBeApplied(StationFiltersDTO $stationFiltersDTO): bool
    {
        return
            !is_null($stationFiltersDTO->getLatitude())
            && !is_null($stationFiltersDTO->getLongitude())
            && !is_null($stationFiltersDTO->getDistance());
    }

    public function fetchCollection(StationFiltersDTO $stationFiltersDTO): Collection
    {
        return $this->stationRepository->getStationsWithinRadiusFromPoint($stationFiltersDTO);
    }

}
