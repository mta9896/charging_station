<?php


namespace App\Http\Controllers\Station;


use App\Station;

class DeleteStationController
{
    public function __invoke(Station $station)
    {
        $station->delete();
    }
}
