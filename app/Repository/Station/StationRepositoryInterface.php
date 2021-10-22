<?php


namespace App\Repository\Station;


use App\Station;
use Illuminate\Support\Collection;

interface StationRepositoryInterface
{
    public function getStationsList() : Collection;

    public function getStation(int $stationId) : Station;
}
