<?php


namespace App\Http\Controllers\Station;


use App\Station;
use Illuminate\Http\Request;

class UpdateStationController
{
    public function __invoke(Station $station, Request $request)
    {
        $request->validate([
            'station.name' => 'nullable|string',
            'station.latitude' => 'nullable|numeric|between:-90,90',
            'station.longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $station->update($request->get('station'));

        return response()->json(['station' => $station]);
    }
}
