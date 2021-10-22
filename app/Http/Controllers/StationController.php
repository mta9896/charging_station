<?php


namespace App\Http\Controllers;


use App\Company;
use App\Station;
use Illuminate\Http\Request;

class StationController
{
    public function index()
    {
        $stations = Station::with('company')->get();

        return response()->json(['stations' => $stations]);
    }

    public function show(Station $station)
    {
        return response()->json(['station' => $station]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'station.name' => 'required|string',
            'station.latitude' => 'required|numeric|between:-90,90',
            'station.longitude' => 'required|numeric|between:-180,180',
            'station.companyId' => 'required|int',
        ]);

        $company = Company::findOrFail($request->input('station.companyId'));
        $station = $company->stations()->create([
            'name' => $request->input('station.name'),
            'latitude' => $request->input('station.latitude'),
            'longitude' => $request->input('station.longitude'),
        ]);

        return response()->json(['station' => $station]);
    }

    public function update(Station $station, Request $request)
    {
        $request->validate([
            'station.name' => 'nullable|string',
            'station.latitude' => 'nullable|numeric|between:-90,90',
            'station.longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $station->update($request->get('station'));

        return response()->json(['station' => $station]);
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
}