<?php


namespace App\Repository\Station;


use App\Company;
use App\DTO\StationDTO;
use App\Station;
use Illuminate\Support\Collection;

interface StationRepositoryInterface
{
    public function getStationsList() : Collection;

    public function getStation(int $stationId) : Station;

    public function createStation(StationDTO $stationDTO, Company $company) : Station;

    public function updateStation(StationDTO $stationDTO, Station $station);

    public function deleteStation(Station $station);
}
