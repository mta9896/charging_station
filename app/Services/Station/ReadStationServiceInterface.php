<?php


namespace App\Services\Station;


use App\DTO\StationFiltersDTO;
use App\Station;
use Illuminate\Support\Collection;

interface ReadStationServiceInterface
{
    public function listStations(StationFiltersDTO $stationFiltersDTO) : Collection;

    public function showSingleStation(int $stationId) : Station;
}
