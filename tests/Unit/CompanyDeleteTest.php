<?php


namespace Tests\Unit;


use App\Company;
use App\Repository\Company\CompanyRepositoryInterface;
use App\Services\Company\DeleteCompanyService;
use Mockery\MockInterface;
use Tests\TestCase;

class CompanyDeleteTest extends TestCase
{
    public function testItDeletesTheCompany()
    {
        $companyId = 1;

        $repository = $this->mock(CompanyRepositoryInterface::class, function (MockInterface $mock) use ($companyId) {
            $company = $this->mock(Company::class);
            $mock->shouldReceive('getCompany')
                ->with($companyId)
                ->once()
                ->andReturn($company);

            $mock->shouldReceive('deleteCompany')
                ->with($company)
                ->once();
        });

        $deleteCompanyService = new DeleteCompanyService($repository);
        $deleteCompanyService->deleteCompany($companyId);
    }
}
