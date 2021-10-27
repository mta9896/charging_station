<?php


namespace App\Http\Controllers;


use App\DTO\StationFiltersDTO;
use App\Http\Resources\Station\StationCollection;
use App\Http\Resources\Station\StationResource;
use App\Services\Station\ReadStationServiceInterface;
use App\Services\Station\StationsInCompanyTreeServiceInterface;
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

    public function __construct(ReadStationServiceInterface $readStationService, StationsInCompanyTreeServiceInterface $stationsInCompanyTreeService)
    {
        $this->readStationService = $readStationService;
        $this->stationsInCompanyTreeService = $stationsInCompanyTreeService;
    }

    public function index(Request $request)
    {

        $filterDTO = new StationFiltersDTO(
            $request->get('latitude'),
            $request->get('longitude'),
            $request->get('distance')
        );

        $stations = $this->readStationService->listStations($filterDTO);

        return new StationCollection($stations);
    }

    public function show(int $stationId)
    {
        $station = $this->readStationService->showSingleStation($stationId);

        return new StationResource($station);
    }

    public function getAllStationsByCompany(int $companyId)
    {
        $stations = $this->stationsInCompanyTreeService->getAllCompanyStations($companyId);

        return new StationCollection($stations);
    }
}
