<?php


namespace App\Http\Controllers\Station;


use App\Station;

class ShowSingleStationController
{
    public function __invoke(Station $station)
    {
        return response()->json(['station' => $station]);
    }
}
