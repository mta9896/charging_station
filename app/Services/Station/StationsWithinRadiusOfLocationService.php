<?php


namespace App\Services\Station;


use App\Company;
use App\DTO\LocationDTO;
use App\Repository\Company\CompanyRepositoryInterface;
use App\Repository\Station\StationRepositoryInterface;
use App\Station;
use Illuminate\Support\Collection;

class StationsWithinRadiusOfLocationService implements StationsWithinRadiusOfLocationServiceInterface
{
    /**
     * @var StationRepositoryInterface
     */
    private $stationRepository;

    public function __construct(StationRepositoryInterface $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    public function getStationsWithinRadiusOfLocation(LocationDTO $locationDTO): Collection
    {
        $stationsArray = $this->stationRepository->getStationsWithinRadius($locationDTO);

        $stations = new Collection();
        foreach ($stationsArray as $stationInfo) {
           $station = new Station();
           $station->id = $stationInfo->id;
           $station->name = $stationInfo->name;
           $station->latitude = (float) $stationInfo->latitude;
           $station->longitude = (float) $stationInfo->longitude;
           $station->company = Company::find($stationInfo->company_id);

           $stations->push($station);
        }

        return $stations;
    }
}
