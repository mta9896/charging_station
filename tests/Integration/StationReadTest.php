<?php


namespace Tests\Integration;


use App\Company;
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
        $company = factory(Company::class)->create();
        $expectedStation = factory(Station::class)->create([
            'company_id' => $company->id,
        ]);

        $station = $this->readStationService->showSingleStation($expectedStation->id);

        $this->assertEquals($expectedStation->name, $station->name);
    }

    public function testItReturnsStationsList()
    {
        $company = factory(Company::class)->create();

        factory(Station::class)->times(10)->create([
            'company_id' => $company,
        ]);

        $stations = $this->readStationService->listStations();

        $this->assertEquals(10, $stations->count());
    }

    public function testItThrowsExceptionWhenStationDoesNotExist()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->readStationService->showSingleStation(100);
    }
}
