<?php


namespace App\Services\Station;


use App\DTO\StationDTO;
use App\Station;

interface CreateStationServiceInterface
{
    public function createStation(StationDTO $stationDTO) : Station;
}
