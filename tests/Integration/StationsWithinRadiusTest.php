<?php


namespace Tests\Integration;


use App\Company;
use App\DTO\StationFiltersDTO;
use App\Repository\Station\StationRepository;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StationsWithinRadiusTest extends TestCase
{
    use DatabaseMigrations;

    private $stationsWithinRadiusService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stationsWithinRadiusService = new StationsWithinRadiusOfLocationService(new StationRepository());
    }

    public function testItReturnsAllStationsWithinRadius()
    {
        $company = factory(Company::class)->create();

        $station1 = $company->stations()->save(factory(Station::class)->make([
            'id' => 1,
            'latitude' => 35.757234,
            'longitude' => 51.403876,
        ])); // 700 meters

        $station2 = $company->stations()->save(factory(Station::class)->make([
            'id' => 2,
            'latitude' => 35.751693,
            'longitude' => 51.410621,
        ])); // 500 meters

        $station3 = $company->stations()->save(factory(Station::class)->make([
            'id' => 3,
            'latitude' => 35.743531,
            'longitude' => 51.400763,
        ])); // 850 meters

        $locationDTO = new StationFiltersDTO(
            35.750500,
            51.405250,
            0.9
        );
        $stations = $this->stationsWithinRadiusService->getStationsWithinRadiusOfLocation($locationDTO);

        $this->assertEquals(3, $stations->count());
        $stationIds = $stations->pluck('id');
        $this->assertContains($station1->id, $stationIds);
        $this->assertContains($station2->id, $stationIds);
        $this->assertContains($station3->id, $stationIds);
    }

    public function testItDoesNotReturnStationsNotInRadius()
    {
        $company = factory(Company::class)->create();

        $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.757234,
            'longitude' => 51.403876,
        ])); // 700 meters

        $company->stations()->save(factory(Station::class)->make([
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
        ])); // 850 meters

        $station5 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.740493,
            'longitude' => 51.416806,
        ])); // 1.18 kilometers

        $locationDTO = new StationFiltersDTO(
            35.750500,
            51.405250,
            0.8
        );
        $stations = $this->stationsWithinRadiusService->getStationsWithinRadiusOfLocation($locationDTO);
        $stationIds = $stations->pluck('id');

        $this->assertEquals(2, $stations->count());
        $this->assertNotContains($station3->id, $stationIds);
        $this->assertNotContains($station4->id, $stationIds);
        $this->assertNotContains($station5->id, $stationIds);
    }


}
