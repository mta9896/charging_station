<?php


namespace Tests\Integration;


use App\Company;
use App\Repository\Company\CompanyRepository;
use App\Services\Company\DeleteCompanyService;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyDeleteTest extends TestCase
{
    use DatabaseMigrations;

    private $deleteCompanyService;

    protected function setUp(): void
    {
        parent::setUp();

        $companyRepository = new CompanyRepository();
        $this->deleteCompanyService = new DeleteCompanyService($companyRepository);
    }

    public function testItDeletesCompanyAndChildStations()
    {
        $company = factory(Company::class)->create([
            'id' => 1,
            'name' => 'Test Company',
        ]);
        $station = $company->stations()->save(factory(Station::class)->make());

        $this->deleteCompanyService->deleteCompany($company->id);

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
        ]);

        $this->assertDatabaseMissing('stations', [
            'id' => $station->id
        ]);
    }

    public function testItDeletesCompanyAndChildCompanies()
    {
        $company = factory(Company::class)->create([
            'id' => 1,
            'name' => 'Test Company',
        ]);
        $childCompany = factory(Company::class)->make();
        $company->children()->save($childCompany);

        $this->deleteCompanyService->deleteCompany($company->id);

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
        ]);

        $this->assertDatabaseMissing('companies', [
            'id' => $childCompany->id
        ]);
    }
}
