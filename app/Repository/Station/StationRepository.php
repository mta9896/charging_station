<?php


namespace App\Repository\Station;


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
}
