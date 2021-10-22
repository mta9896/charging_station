<?php


namespace App\Services\Station;


use App\DTO\StationDTO;

interface UpdateStationServiceInterface
{
    public function updateStation(int $stationId, StationDTO $stationDTO);
}
