<?php


namespace App\Services\Station;


use App\DTO\StationDTO;
use App\Station;

interface UpdateStationServiceInterface
{
    public function updateStation(int $stationId, StationDTO $stationDTO) : Station;
}
