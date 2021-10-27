<?php

namespace Tests\Feature;

use App\Company;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyDeleteTest extends TestCase
{
    use DatabaseMigrations;

    public function testItDeletesTheCompany()
    {
        $company = factory(Company::class)->create();

        $response = $this->deleteJson('/api/companies/' . $company->id);
        $response->assertStatus(200);

        $response = $this->getJson('/api/companies/' . $company->id);
        $response->assertStatus(404);

    }

    public function testItDeletesStationsWhenCompanyIsDeleted()
    {
        $company = factory(Company::class)->create();
        $station = $company->stations()->save(factory(Station::class)->make());

        $response = $this->deleteJson('/api/companies/' . $company->id);
        $response->assertStatus(200);

        $response = $this->getJson('/api/stations/' . $station->id);
        $response->assertStatus(404);
    }

    public function testItDeletesChildCompaniesWhenCompanyIsDeleted()
    {
        $parentCompany = factory(Company::class)->create();
        $childCompany = factory(Company::class)->make();
        $childCompany = $parentCompany->children()->save($childCompany);

        $response = $this->deleteJson('/api/companies/' . $parentCompany->id);
        $response->assertStatus(200);

        $response = $this->getJson('/api/companies/' . $childCompany->id);
        $response->assertStatus(404);
    }
}
