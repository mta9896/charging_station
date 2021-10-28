<?php


namespace Tests\Unit;


use App\Company;
use App\DTO\CompanyDTO;
use App\Repository\Company\CompanyRepositoryInterface;
use App\Services\Company\CreateCompanyService;
use Mockery\MockInterface;
use Tests\TestCase;

class CompanyCreateTest extends TestCase
{
    public function testItCreatesCompanyWithoutParent()
    {
        $companyDTO = new CompanyDTO('New Company');
        $repository = $this->mock(CompanyRepositoryInterface::class, function (MockInterface $mock) use ($companyDTO) {
            $mock->shouldReceive('createCompany')
                ->with($companyDTO)
                ->once();

            $mock->shouldNotReceive('assignCompanyToParent');
        });

        $createCompanyService = new CreateCompanyService($repository);
        $createCompanyService->createCompany($companyDTO);
    }

    public function testItCreatesCompanyWithParent()
    {
        $companyDTO = new CompanyDTO('New Company', 1);

        $repository = $this->mock(CompanyRepositoryInterface::class, function (MockInterface $mock) use ($companyDTO) {
            $company = $this->mock(Company::class);
            $mock->shouldReceive('createCompany')
                ->with($companyDTO)
                ->once()
                ->andReturn($company);

            $parentCompany = $this->mock(Company::class);
            $mock->shouldReceive('getCompany')
                ->with(1)
                ->once()
                ->andReturn($parentCompany);

            $mock->shouldReceive('assignCompanyToParent')
                ->once()
                ->with($parentCompany, $company);
        });

        $createCompanyService = new CreateCompanyService($repository);
        $createCompanyService->createCompany($companyDTO);
    }
}
