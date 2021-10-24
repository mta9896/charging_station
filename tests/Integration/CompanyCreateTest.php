<?php


namespace Tests\Integration;


use App\Company;
use App\DTO\CompanyDTO;
use App\Repository\Company\CompanyRepository;
use App\Services\Company\CreateCompanyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyCreateTest extends TestCase
{
    use DatabaseMigrations;

    private $createCompanyService;

    protected function setUp(): void
    {
        parent::setUp();

        $companyRepository = new CompanyRepository();
        $this->createCompanyService = new CreateCompanyService($companyRepository);
    }

    public function testItCreatesParentCompany()
    {
        $companyDTO = new CompanyDTO('Test Company', null);

        $this->createCompanyService->createCompany($companyDTO);

        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'parent_id' => null,
        ]);
    }

    public function testItCreatesChildCompany()
    {
        $parentCompany = factory(Company::class)->create([
            'id' => 1,
            'name' => 'Test Parent Company'
        ]);

        $companyDTO = new CompanyDTO('Test Company', $parentCompany->id);

        $this->createCompanyService->createCompany($companyDTO);

        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'parent_id' => $parentCompany->id,
        ]);
    }

    public function testItThrowsExceptionWhenParentCompanyDoesNotExist()
    {
        $companyDTO = new CompanyDTO('Test Company', 10);

        $this->expectException(ModelNotFoundException::class);

        $this->createCompanyService->createCompany($companyDTO);
    }
}
