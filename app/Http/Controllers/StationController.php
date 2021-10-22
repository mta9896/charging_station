<?php


namespace App\Http\Controllers;


use App\DTO\StationDTO;
use App\Http\Requests\CreateStationRequest;
use App\Http\Requests\UpdateStationRequest;
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

    public function create(CreateStationRequest $request)
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

    public function update(int $stationId, UpdateStationRequest $request)
    {
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
