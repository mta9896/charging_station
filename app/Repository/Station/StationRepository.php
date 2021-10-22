<?php


namespace App\Repository\Station;


use App\Company;
use App\DTO\LocationDTO;
use App\DTO\StationDTO;
use App\Station;
use Illuminate\Support\Collection;

class StationRepository implements StationRepositoryInterface
{
    public function getStationsList() : Collection
    {
        return Station::with('company')->get();
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

    public function getStationsWithinRadius(LocationDTO $locationDTO)
    {
        $query = "
            SELECT id, name, latitude, longitude, company_id, ( 6371 * acos( cos( radians(:lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(:long) ) + sin( radians(:latitude) ) * sin(radians(latitude)) ) ) AS distance
            FROM stations
            HAVING distance < :distance
            ORDER BY distance
        ";

        $result = \DB::select($query,[
            'lat' => $locationDTO->getLatitude(),
            'long' => $locationDTO->getLongitude(),
            'latitude' => $locationDTO->getLatitude(),
            'distance' => $locationDTO->getDistance(),
        ]);

        return $result;
    }
}
