<?php


namespace Tests\Integration;


use App\Company;
use App\DTO\StationFiltersDTO;
use App\Repository\Station\StationRepository;
use App\Services\Station\ReadStationService;
use App\Station;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StationReadTest extends TestCase
{
    use DatabaseMigrations;

    private $readStationService;

    protected function setUp(): void
    {
        parent::setUp();

        $stationRepository = new StationRepository();
        $this->readStationService = new ReadStationService($stationRepository);
    }

    public function testItReturnsSingleStation()
    {
        $company = Company::factory()->create();
        $expectedStation = factory(Station::class)->create([
            'company_id' => $company->id,
        ]);

        $station = $this->readStationService->showSingleStation($expectedStation->id);

        $this->assertEquals($expectedStation->name, $station->name);
    }

    public function testItReturnsStationsList()
    {
        $company = Company::factory()->create();

        factory(Station::class)->times(10)->create([
            'company_id' => $company,
        ]);

        $stationFiltersDTO = new StationFiltersDTO();
        $stations = $this->readStationService->listStations($stationFiltersDTO);

        $this->assertEquals(10, $stations->count());
    }

    public function testItReturnsAllStationsWithinRadius()
    {
        $company = Company::factory()->create();

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

        $stationFiltersDTO = new StationFiltersDTO(
            35.750500,
            51.405250,
            0.9
        );
        $stations = $this->readStationService->listStations($stationFiltersDTO);

        $this->assertEquals(3, $stations->count());
        $stationIds = $stations->pluck('id');
        $this->assertContains($station1->id, $stationIds);
        $this->assertContains($station2->id, $stationIds);
        $this->assertContains($station3->id, $stationIds);
    }

    public function testItDoesNotReturnStationsNotInRadius()
    {
        $company = Company::factory()->create();

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

        $stationFiltersDTO = new StationFiltersDTO(
            35.750500,
            51.405250,
            0.8
        );
        $stations = $this->readStationService->listStations($stationFiltersDTO);
        $stationIds = $stations->pluck('id');

        $this->assertEquals(2, $stations->count());
        $this->assertNotContains($station3->id, $stationIds);
        $this->assertNotContains($station4->id, $stationIds);
        $this->assertNotContains($station5->id, $stationIds);
    }

    public function testItThrowsExceptionWhenStationDoesNotExist()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->readStationService->showSingleStation(100);
    }
}
