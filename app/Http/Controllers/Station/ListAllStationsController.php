<?php


namespace App\Http\Controllers\Station;


use App\Station;

class ListAllStationsController
{
    public function __invoke()
    {
        $stations = Station::with('company')->get();

        return response()->json(['stations' => $stations]);
    }
}
