<?php


namespace App\Repository\Station;


use App\Company;
use App\Constants\CoordinatesConstants;
use App\Constants\PaginationConstants;
use App\DTO\StationFiltersDTO;
use App\DTO\StationDTO;
use App\Station;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StationRepository implements StationRepositoryInterface
{
    public function getStationsList() : Collection
    {
        $stations = Station::with('company')
            ->paginate(PaginationConstants::STATIONS_PAGE_SIZE);

        return new Collection($stations->items());
    }

    public function getStationsWithinRadiusFromPoint(StationFiltersDTO $stationFiltersDTO) : Collection
    {
        $queryBuilder = DB::table('stations')
            ->select()
            ->addSelect(DB::raw('( ? * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin(radians(latitude)) ) ) AS distance'))
            ->setBindings([CoordinatesConstants::EARTH_RADIUS_KILOMETERS, $stationFiltersDTO->getLatitude(), $stationFiltersDTO->getLongitude(), $stationFiltersDTO->getLatitude()])
            ->having('distance', '<=', $stationFiltersDTO->getDistance())
            ->orderBy('distance');

        $result = $queryBuilder
            ->paginate(PaginationConstants::STATIONS_PAGE_SIZE);

        return Station::hydrate($result->items());
    }

    public function getStation(int $stationId) : Station
    {
        return Station::findOrFail($stationId);
    }

    public function createStation(StationDTO $stationDTO, Company $company): Station
    {
        $station = $company->stations()->create([
            'name' => $stationDTO->getName(),
            'latitude' => $stationDTO->getLatitude(),
            'longitude' => $stationDTO->getLongitude(),
        ]);

        return $station;
    }

    public function updateStation(StationDTO $stationDTO, Station $station)
    {
        $station->update([
            'name' => $stationDTO->getName(),
            'latitude' => $stationDTO->getLatitude(),
            'longitude' => $stationDTO->getLongitude(),
        ]);
    }

    public function deleteStation(Station $station)
    {
        $station->delete();
    }

    public function getStationsByCompanyIds(Collection $companyIds) : Collection
    {
        return Station::whereIn('company_id', $companyIds)->paginate(PaginationConstants::STATIONS_PAGE_SIZE);
    }
}
