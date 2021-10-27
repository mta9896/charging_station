<?php


namespace App\Repository\Station;


use App\Company;
use App\DTO\StationFiltersDTO;
use App\DTO\StationDTO;
use App\Station;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface StationRepositoryInterface
{
    public function getStationsList(StationFiltersDTO $locationDTO) : Collection;

    public function getStation(int $stationId) : Station;

    public function createStation(StationDTO $stationDTO, Company $company) : Station;

    public function updateStation(StationDTO $stationDTO, Station $station);

    public function deleteStation(Station $station);

    public function getStationsByCompanyIds(Collection $companyIds);
}
