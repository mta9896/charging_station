<?php


namespace Tests\Unit;


use App\Company;
use App\DTO\CompanyDTO;
use App\Repository\Company\CompanyRepositoryInterface;
use App\Services\Company\UpdateCompanyService;
use Mockery\MockInterface;
use Tests\TestCase;

class CompanyUpdateTest extends TestCase
{
    public function testItUpdatesTheCompany()
    {
        $companyId = 1;
        $companyDTO = new CompanyDTO('New Company');

        $repository = $this->mock(CompanyRepositoryInterface::class, function (MockInterface $mock) use ($companyId, $companyDTO) {
            $company = $this->mock(Company::class);
            $mock->shouldReceive('getCompany')
                ->with($companyId)
                ->once()
                ->andReturn($company);

            $mock->shouldReceive('updateCompany')
                ->with($company, $companyDTO)
                ->once();
        });

        $updateCompanyService = new UpdateCompanyService($repository);
        $updateCompanyService->updateCompany($companyDTO, $companyId);
    }
}
