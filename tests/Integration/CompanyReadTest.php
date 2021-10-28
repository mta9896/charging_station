<?php


namespace Tests\Integration;


use App\Company;
use App\Repository\Company\CompanyRepository;
use App\Services\Company\ReadCompanyService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyReadTest extends TestCase
{
    use DatabaseMigrations;

    private $readCompanyService;

    protected function setUp(): void
    {
        parent::setUp();

        $companyRepository = new CompanyRepository();
        $this->readCompanyService = new ReadCompanyService($companyRepository);
    }

    public function testItReturnsSingleCompany()
    {
        $expectedCompany = Company::factory()->create([
            'id' => 1,
            'name' => 'Test Company'
        ]);

        $company = $this->readCompanyService->showSingleCompany($expectedCompany->id);

        $this->assertEquals($expectedCompany->name, $company->name);
    }

    public function testItReturnsCompanyList()
    {
        Company::factory()->times(10)->create();

        $companies = $this->readCompanyService->listCompanies();

        $this->assertEquals(10, $companies->count());
    }

    public function testItCreatesChildCompany()
    {
        $parentCompany = Company::factory()->create([
            'id' => 1,
            'name' => 'Parent Company',
        ]);
        Company::factory()->create([
            'id' => 2,
            'name' => 'Child Company',
            'parent_id' => 1,
        ]);

        $company = $this->readCompanyService->showSingleCompany(2);

        $this->assertEquals($parentCompany->id, $company->parent->id);
    }

    public function testItReturnsEmptyCollectionWhenNoCompanyExists()
    {
        $companies = $this->readCompanyService->listCompanies();

        $this->assertEquals(0, $companies->count());
    }
}
