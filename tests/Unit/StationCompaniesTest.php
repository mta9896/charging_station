<?php


namespace Tests\Unit;


use App\Company;
use App\Repository\Company\CompanyRepository;
use App\Repository\Station\StationRepository;
use App\Services\Station\StationsInCompanyTreeService;
use Mockery\MockInterface;
use Tests\TestCase;

class StationCompaniesTest extends TestCase
{
    public function testItReturnsAllCompanyStations()
    {
        $companyId = 1;
        $companyRepository = $this->mock(CompanyRepository::class, function (MockInterface $mock) use ($companyId) {
            $company = $this->mock(Company::class);
            $mock->shouldReceive('getCompany')
                ->with($companyId)
                ->once()
                ->andReturn($company);

            $mock->shouldReceive('getCompanyDescendantsAndSelfIds')
                ->with($company)
                ->once();

        });

        $stationRepository = $this->mock(StationRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getStationsByCompanyIds')
                ->once();
        });

        $stationsInCompanyTreeService = new StationsInCompanyTreeService($stationRepository, $companyRepository);
        $stationsInCompanyTreeService->getAllCompanyStations($companyId);
    }
}
