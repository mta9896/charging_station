<?php


namespace App\Services\Station;


use App\Station;
use Illuminate\Support\Collection;

interface ReadStationServiceInterface
{
    public function listStations() : Collection;

    public function showSingleStation(int $stationId) : Station;
}
