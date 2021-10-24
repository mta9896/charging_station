<?php


namespace Tests\Integration;


use App\Company;
use App\DTO\StationDTO;
use App\Repository\Company\CompanyRepository;
use App\Repository\Station\StationRepository;
use App\Services\Station\UpdateStationService;
use App\Station;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StationUpdateTest extends TestCase
{
    use DatabaseMigrations;

    private $updateStationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->updateStationService = new UpdateStationService(new CompanyRepository(), new StationRepository());
    }

    public function testItUpdatesStation()
    {
        $company = factory(Company::class)->create();
        $station = factory(Station::class)->create([
            'name' => 'Test Station',
            'latitude' => 11.1111,
            'longitude' => 22.2222,
            'company_id' => $company->id,
        ]);

        $stationDTO = new StationDTO(
            'New Station Name',
            33.3333,
            44.4444,
            $company->id
        );

        $this->updateStationService->updateStation($station->id, $stationDTO);

        $this->assertDatabaseHas('stations', [
            'id' => $station->id,
            'name' => 'New Station Name',
            'latitude' => 33.3333,
            'longitude' => 44.4444,
            'company_id' => $company->id,
        ]);
    }

    public function testItThrowsExceptionWhenStationDoesNotExist()
    {
        $company = factory(Company::class)->create();

        $stationDTO = new StationDTO(
            'New Station Name',
            33.3333,
            44.4444,
            $company->id
        );

        $this->expectException(ModelNotFoundException::class);

        $this->updateStationService->updateStation(100, $stationDTO);
    }
}
