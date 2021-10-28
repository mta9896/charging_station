<?php


namespace App\Services\Station\StationFetch;


use App\DTO\StationFiltersDTO;
use Illuminate\Support\Collection;

interface StationFetchStrategy
{
    public function shouldBeApplied(StationFiltersDTO $stationFiltersDTO) : bool;

    public function fetchCollection(StationFiltersDTO $stationFiltersDTO) : Collection;
}
