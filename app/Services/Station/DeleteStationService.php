<?php


namespace App\Services\Station;


use App\Repository\Company\CompanyRepositoryInterface;
use App\Repository\Station\StationRepositoryInterface;

class DeleteStationService implements DeleteStationServiceInterface
{
    /**
     * @var StationRepositoryInterface
     */
    private $stationRepository;

    public function __construct(StationRepositoryInterface $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    public function deleteStation(int $stationId)
    {
        $station = $this->stationRepository->getStation($stationId);

        $this->stationRepository->deleteStation($station);
    }
}
