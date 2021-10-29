<?php


namespace App\Http\Controllers;


use App\DTO\StationDTO;
use App\DTO\StationFiltersDTO;
use App\Http\Requests\CreateStationRequest;
use App\Http\Requests\UpdateStationRequest;
use App\Http\Resources\Station\StationCollection;
use App\Http\Resources\Station\StationResource;
use App\Services\Station\CreateStationServiceInterface;
use App\Services\Station\DeleteStationServiceInterface;
use App\Services\Station\ReadStationServiceInterface;
use App\Services\Station\UpdateStationServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StationController
{
    public function __construct(
        private ReadStationServiceInterface $readStationService,
        private CreateStationServiceInterface $createStationService,
        private UpdateStationServiceInterface $updateStationService,
        private DeleteStationServiceInterface $deleteStationService)
    {
    }

    public function index(Request $request) : StationCollection
    {
        $filterDTO = new StationFiltersDTO(
            $request->get('latitude'),
            $request->get('longitude'),
            $request->get('distance')
        );

        $stations = $this->readStationService->listStations($filterDTO);

        return new StationCollection($stations);
    }

    public function show(int $stationId) : StationResource
    {
        $station = $this->readStationService->showSingleStation($stationId);

        return new StationResource($station);
    }

    public function create(CreateStationRequest $request) : StationResource
    {
        $stationDTO = new StationDTO(
            $request->input('station.name'),
            $request->input('station.latitude'),
            $request->input('station.longitude'),
            $request->input('station.companyId')
        );

        $station = $this->createStationService->createStation($stationDTO);

        return new StationResource($station);
    }

    public function update(int $stationId, UpdateStationRequest $request) : StationResource
    {
        $stationDTO = new StationDTO(
            $request->input('station.name'),
            $request->input('station.latitude'),
            $request->input('station.longitude')
        );

        $station = $this->updateStationService->updateStation($stationId, $stationDTO);

        return new StationResource($station);
    }

    public function delete(int $stationId) : Response
    {
        $this->deleteStationService->deleteStation($stationId);

        return new Response('', '204');
    }
}
