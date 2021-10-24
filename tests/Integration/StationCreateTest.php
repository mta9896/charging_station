<?php


namespace Tests\Integration;


use App\Company;
use App\DTO\StationDTO;
use App\Repository\Company\CompanyRepository;
use App\Repository\Station\StationRepository;
use App\Services\Station\CreateStationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StationCreateTest extends TestCase
{
    use DatabaseMigrations;

    private $createStationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createStationService = new CreateStationService(new CompanyRepository(), new StationRepository());
    }

    public function testItCreatesStation()
    {
        $company = factory(Company::class)->create();

        $stationDTO = new StationDTO(
            'Station Name',
            35.6677,
            51.45345,
            $company->id
        );

        $station = $this->createStationService->createStation($stationDTO);

        $this->assertDatabaseHas('stations', [
            'id' => $station->id,
            'name' => 'Station Name',
            'latitude' => 35.6677,
            'longitude' => 51.45345,
            'company_id' => $company->id,
        ]);
    }

    public function testItThrowsExceptionWhenParentCompanyDoesntExist()
    {
        $stationDTO = new StationDTO(
            'Station Name',
            35.6677,
            51.45345,
            11
        );

        $this->expectException(ModelNotFoundException::class);

        $this->createStationService->createStation($stationDTO);
    }
}
