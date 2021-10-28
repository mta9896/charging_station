<?php


namespace Tests\Unit;


use App\Repository\Company\CompanyRepositoryInterface;
use App\Services\Company\ReadCompanyService;
use Mockery\MockInterface;
use Tests\TestCase;

class CompanyReadTest extends TestCase
{
    public function testItReturnsCompanyList()
    {
        $repository = $this->mock(CompanyRepositoryInterface::class, function (MockInterface $mock){
            $mock->shouldReceive('getCompaniesList')
                ->once();
        });

        $readCompanyService = new ReadCompanyService($repository);
        $readCompanyService->listCompanies();
    }

    public function testItReturnsSingleCompany()
    {
        $companyId = 1;
        $repository = $this->mock(CompanyRepositoryInterface::class, function (MockInterface $mock) use ($companyId) {
            $mock->shouldReceive('getCompany')
                ->with($companyId)
                ->once();
        });

        $readCompanyService = new ReadCompanyService($repository);
        $readCompanyService->showSingleCompany($companyId);
    }
}
