<?php


namespace App\Http\Controllers;


use App\DTO\StationDTO;
use App\Http\Resources\Station\StationResource;
use App\Services\Station\CreateStationServiceInterface;
use App\Services\Station\DeleteStationServiceInterface;
use App\Services\Station\UpdateStationServiceInterface;
use Illuminate\Http\Request;

class StationController
{
    /**
     * @var CreateStationServiceInterface
     */
    private $createStationService;

    /**
     * @var UpdateStationServiceInterface
     */
    private $updateStationService;

    /**
     * @var DeleteStationServiceInterface
     */
    private $deleteStationService;

    public function __construct(CreateStationServiceInterface $createStationService, UpdateStationServiceInterface $updateStationService, DeleteStationServiceInterface $deleteStationService)
    {
        $this->createStationService = $createStationService;
        $this->updateStationService = $updateStationService;
        $this->deleteStationService = $deleteStationService;
    }

    public function create(Request $request)
    {
        $request->validate([
            'station.name' => 'required|string',
            'station.latitude' => 'required|numeric|between:-90,90',
            'station.longitude' => 'required|numeric|between:-180,180',
            'station.companyId' => 'required|int',
        ]);

        $stationDTO = new StationDTO(
            $request->input('station.name'),
            $request->input('station.latitude'),
            $request->input('station.longitude'),
            $request->input('station.companyId')
        );

        $station = $this->createStationService->createStation($stationDTO);

        return new StationResource($station);
    }

    public function update(int $stationId, Request $request)
    {
        $request->validate([
            'station.name' => 'nullable|string',
            'station.latitude' => 'nullable|numeric|between:-90,90',
            'station.longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $stationDTO = new StationDTO(
            $request->input('station.name'),
            $request->input('station.latitude'),
            $request->input('station.longitude')
        );

        $station = $this->updateStationService->updateStation($stationId, $stationDTO);

        return new StationResource($station);
    }

    public function delete(int $stationId)
    {
        $this->deleteStationService->deleteStation($stationId);
    }
}
