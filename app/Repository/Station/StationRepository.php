<?php


namespace App\Repository\Station;


use App\Company;
use App\Constants\CoordinatesConstants;
use App\Constants\PaginationConstants;
use App\DTO\StationFiltersDTO;
use App\DTO\StationDTO;
use App\Station;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StationRepository implements StationRepositoryInterface
{
    public function getStationsList(StationFiltersDTO $locationDTO) : Collection
    {
        $queryBuilder = DB::table('stations')
            ->select();

        if ($locationDTO->getLatitude() && $locationDTO->getLongitude()) {
            $queryBuilder->addSelect(DB::raw('( ? * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin(radians(latitude)) ) ) AS distance'))
                ->setBindings([CoordinatesConstants::EARTH_RADIUS_KILOMETERS, $locationDTO->getLatitude(), $locationDTO->getLongitude(), $locationDTO->getLatitude()])
                ->having('distance', '<=', $locationDTO->getDistance());
        }

        if ($locationDTO->getDistance()) {
            $queryBuilder
                ->orderBy('distance');
        }

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

    public function getStationsByCompanyIds(Collection $companyIds)
    {
        return Station::whereIn('company_id', $companyIds)->paginate(PaginationConstants::STATIONS_PAGE_SIZE);
    }
}
