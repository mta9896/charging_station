<?php


namespace Tests\Integration;


use App\Company;
use App\Repository\Station\StationRepository;
use App\Services\Station\DeleteStationService;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StationDeleteTest extends TestCase
{
    use DatabaseMigrations;

    private $deleteStationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteStationService = new DeleteStationService(new StationRepository());
    }

    public function testItDeletesStation()
    {
        $company = Company::factory()->create();
        $station = factory(Station::class)->create([
            'company_id' => $company->id,
        ]);

        $this->deleteStationService->deleteStation($station->id);

        $this->assertDatabaseMissing('stations', [
           'id' => $station->id,
        ]);
    }
}
