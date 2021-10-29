<?php


namespace App\Services\Station;


use App\Repository\Company\CompanyRepositoryInterface;
use App\Repository\Station\StationRepositoryInterface;

class DeleteStationService implements DeleteStationServiceInterface
{
    public function __construct(private StationRepositoryInterface $stationRepository)
    {
    }

    public function deleteStation(int $stationId) : void
    {
        $station = $this->stationRepository->getStation($stationId);

        $this->stationRepository->deleteStation($station);
    }
}
