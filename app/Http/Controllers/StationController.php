<?php


namespace App\Http\Controllers;


use App\Company;
use App\DTO\StationDTO;
use App\Http\Resources\Station\StationCollection;
use App\Http\Resources\Station\StationResource;
use App\Services\Station\CreateStationService;
use App\Services\Station\CreateStationServiceInterface;
use App\Services\Station\ReadStationServiceInterface;
use App\Station;
use Illuminate\Http\Request;

class StationController
{
    /**
     * @var ReadStationServiceInterface
     */
    private $readStationService;

    /**
     * @var CreateStationServiceInterface
     */
    private $createStationService;

    public function __construct(ReadStationServiceInterface $readStationService, CreateStationServiceInterface $createStationService)
    {
        $this->readStationService = $readStationService;
        $this->createStationService = $createStationService;
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

    public function update(Station $station, Request $request)
    {
        $request->validate([
            'station.name' => 'nullable|string',
            'station.latitude' => 'nullable|numeric|between:-90,90',
            'station.longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $station->update($request->get('station'));

        return new StationResource($station);
    }

    public function delete(Station $station)
    {
        $station->delete();
    }

    public function getAllStationsWithinRadius(Request $request)
    {
        $distance = $request->get('distance');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');

        $query = "
            SELECT id, name, latitude, longitude, ( 6371 * acos( cos( radians(:lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(:long) ) + sin( radians(:latitude) ) * sin(radians(latitude)) ) ) AS distance
            FROM stations
            HAVING distance < :distance
            ORDER BY distance
        ";

        $result = \DB::select($query,[
            'lat' => $latitude,
            'long' => $longitude,
            'latitude' => $latitude,
            'distance' => $distance,
        ]);

        return response()->json(['stations' => $result]);
    }

    public function getAllStationsByCompany(Company $company)
    {
        $companies = Company::descendantsAndSelf($company->id);
        $companyIds = $companies->pluck('id');

        $stations = Station::whereIn('company_id', $companyIds)->get();

        return new StationCollection($stations);
    }
}
