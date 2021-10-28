<?php


namespace Tests\Integration;


use App\Company;
use App\DTO\CompanyDTO;
use App\Repository\Company\CompanyRepository;
use App\Services\Company\UpdateCompanyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyUpdateTest extends TestCase
{
    use DatabaseMigrations;

    private $updateCompanyService;

    protected function setUp(): void
    {
        parent::setUp();

        $companyRepository = new CompanyRepository();
        $this->updateCompanyService = new UpdateCompanyService($companyRepository);
    }

    public function testItUpdatesTheCompany()
    {
        $company = Company::factory()->create([
            'id' => 1,
            'name' => 'Test Company'
        ]);

        $companyDTO = new CompanyDTO('New Company Name');

        $this->updateCompanyService->updateCompany($companyDTO, $company->id);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'New Company Name',
        ]);
    }

    public function testItThrowsExceptionWhenParentCompanyDoesNotExist()
    {
        $companyDTO = new CompanyDTO('New Company Name');

        $this->expectException(ModelNotFoundException::class);

        $this->updateCompanyService->updateCompany($companyDTO, 10);
    }
}
