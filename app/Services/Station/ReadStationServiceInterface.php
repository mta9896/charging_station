<?php


namespace App\Services\Station;


use App\Station;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ReadStationServiceInterface
{
    public function listStations() : LengthAwarePaginator;

    public function showSingleStation(int $stationId) : Station;
}
