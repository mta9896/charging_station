<?php


namespace App\Http\Controllers\Station;


use App\Company;
use Illuminate\Http\Request;

class CreateStationController
{
    public function __invoke(Request $request)
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
}
