<?php


namespace App\Services\Station;


use App\DTO\LocationDTO;
use Illuminate\Support\Collection;

interface StationsWithinRadiusOfLocationServiceInterface
{
    public function getStationsWithinRadiusOfLocation(LocationDTO $locationDTO) : Collection;
}
