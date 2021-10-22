<?php


namespace App\Http\Controllers;


use App\DTO\LocationDTO;
use App\Http\Resources\Station\StationCollection;
use App\Http\Resources\Station\StationResource;
use App\Services\Station\ReadStationServiceInterface;
use App\Services\Station\StationsInCompanyTreeServiceInterface;
use App\Services\Station\StationsWithinRadiusOfLocationServiceInterface;
use Illuminate\Http\Request;

class StationListController
{
    /**
     * @var ReadStationServiceInterface
     */
    private $readStationService;

    /**
     * @var StationsInCompanyTreeServiceInterface
     */
    private $stationsInCompanyTreeService;

    /**
     * @var StationsWithinRadiusOfLocationServiceInterface
     */
    private $stationsWithinRadiusService;

    public function __construct(ReadStationServiceInterface $readStationService, StationsInCompanyTreeServiceInterface $stationsInCompanyTreeService, StationsWithinRadiusOfLocationServiceInterface $stationsWithinRadiusService)
    {
        $this->readStationService = $readStationService;
        $this->stationsInCompanyTreeService = $stationsInCompanyTreeService;
        $this->stationsWithinRadiusService = $stationsWithinRadiusService;
    }

    public function index()
    {
        $stations = $this->readStationService->listStations();

        return new StationCollection($stations);
    }

    public function show(int $stationId)
    {
        $station = $this->readStationService->showSingleStation($stationId);

        return new StationResource($station);
    }

    public function getAllStationsWithinRadius(Request $request)
    {
        $locationDTO = new LocationDTO(
            $request->get('latitude'),
            $request->get('longitude'),
            $request->get('distance')
        );

        $stations = $this->stationsWithinRadiusService->getStationsWithinRadiusOfLocation($locationDTO);

        return new StationCollection($stations);
    }

    public function getAllStationsByCompany(int $companyId)
    {
        $stations = $this->stationsInCompanyTreeService->getAllCompanyStations($companyId);

        return new StationCollection($stations);
    }
}
