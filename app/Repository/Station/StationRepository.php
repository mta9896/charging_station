<?php


namespace App\Repository\Station;


use App\Company;
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
}
