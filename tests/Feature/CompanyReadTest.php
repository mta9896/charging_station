<?php


namespace Tests\Feature;


use App\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CompanyReadTest extends TestCase
{
    use DatabaseMigrations;

    public function testItReturnsSingleCompanyById()
    {
        $company = factory(Company::class)->create();

        $response = $this->getJson('/api/companies/' . $company->id);
        $response->assertStatus(200);
        $response->assertJson([
           'data' => $this->serializeCompany($company),
        ]);

    }

    public function testItReturnsCompaniesList()
    {
        $companies = factory(Company::class)->times(10)->create();

        $response = $this->getJson('/api/companies');


        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeCompaniesArray($companies),
        ]);
    }

    public function testItReturnsCompanyWithParentCorrectly()
    {
        $parentCompany = factory(Company::class)->create();
        $childrenCompanies = $parentCompany->children()->saveMany(factory(Company::class)->times(5)->make());

        $companies = new Collection();
        $companies->push($parentCompany);
        $response = $this->getJson('/api/companies');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeCompaniesArray($companies->merge($childrenCompanies)),
        ]);
    }

    public function testItReturnsEmptyArrayWhenNoCompaniesExist()
    {
        $response = $this->getJson('/api/companies');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [],
        ]);
    }

    public function testItReturnsNotFoundWhenStationDoesntExist()
    {
        $response = $this->getJson('/api/companies/1000');

        $response->assertStatus(404);
    }

    private function serializeCompaniesArray(Collection $companies)
    {
        $result = [];
        foreach ($companies as $company) {
            $result [] = $this->serializeCompany($company);
        }

        return $result;
    }

    private function serializeCompany(Company $company)
    {
        return [
            'id' => $company->id,
            'name' => $company->name,
            'parentCompany' => empty($company->parent()->count()) ? [] : [
                'id' => $company->parent()->first()->id,
                'name' => $company->parent()->first()->name,
            ]
        ];
    }
}
