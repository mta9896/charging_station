<?php


namespace Tests\Unit;


use App\Company;
use App\DTO\StationDTO;
use App\Repository\Company\CompanyRepository;
use App\Repository\Station\StationRepository;
use App\Services\Station\CreateStationService;
use Mockery\MockInterface;
use Tests\TestCase;

class StationCreateTest extends TestCase
{
    public function testItCreatesStation()
    {
        $companyId = 1;
        $stationDTO = new StationDTO(
            'Station Name',
            35.6677,
            51.45345,
            $companyId
        );
        $company = $this->mock(Company::class);

        $companyRepository = $this->mock(CompanyRepository::class, function (MockInterface $mock) use ($stationDTO, $company) {
            $mock->shouldReceive('getCompany')
                ->with($stationDTO->getCompanyId())
                ->once()
                ->andReturn($company);
        });

        $stationRepository = $this->mock(StationRepository::class, function (MockInterface $mock) use ($stationDTO, $company) {
            $mock->shouldReceive('createStation')
                ->with($stationDTO, $company)
                ->once();
        });

        $createStationService = new CreateStationService($companyRepository, $stationRepository);
        $createStationService->createStation($stationDTO);
    }
}
