<?php


namespace Tests\Feature;


use App\Company;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ListStationWithinRadiusTest extends TestCase
{
    use DatabaseMigrations;

    public function testItReturnsAllStationsWithinRadiusFromAPoint()
    {
        $company = factory(Company::class)->create();

        $station1 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.757234,
            'longitude' => 51.403876,
        ])); // 700 meters

        $station2 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.751693,
            'longitude' => 51.410621,
        ])); // 500 meters

        $station3 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.741780,
            'longitude' => 51.402093,
        ])); // 1.01 kilometer

        $station4 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.743531,
            'longitude' => 51.400763,
        ])); // 800 meters

        $station5 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.740493,
            'longitude' => 51.416806,
        ])); // 1.18 kilometers

        dd("here");
        //assert not exists
        $latitude = 35.750500;
        $longitude = 51.405250;
    }
}
