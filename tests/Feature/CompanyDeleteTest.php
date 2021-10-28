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
        $company = Company::factory()->create();

        $response = $this->deleteJson('/api/companies/' . $company->id);
        $response->assertStatus(200);

        $response = $this->getJson('/api/companies/' . $company->id);
        $response->assertStatus(404);

    }

    public function testItDeletesStationsWhenCompanyIsDeleted()
    {
        $company = Company::factory()->create();
        $station = $company->stations()->save(Station::factory()->make());

        $response = $this->deleteJson('/api/companies/' . $company->id);
        $response->assertStatus(200);

        $response = $this->getJson('/api/stations/' . $station->id);
        $response->assertStatus(404);
    }

    public function testItDeletesChildCompaniesWhenCompanyIsDeleted()
    {
        $parentCompany = Company::factory()->create();
        $childCompany = Company::factory()->make();
        $childCompany = $parentCompany->children()->save($childCompany);

        $response = $this->deleteJson('/api/companies/' . $parentCompany->id);
        $response->assertStatus(200);

        $response = $this->getJson('/api/companies/' . $childCompany->id);
        $response->assertStatus(404);
    }
}
