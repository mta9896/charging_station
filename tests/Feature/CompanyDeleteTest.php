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
        $response->assertStatus(204);

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id
        ]);
    }

    public function testItDeletesStationsWhenCompanyIsDeleted()
    {
        $company = Company::factory()->create();
        $station = $company->stations()->save(Station::factory()->make());

        $response = $this->deleteJson('/api/companies/' . $company->id);
        $response->assertStatus(204);

        $this->assertDatabaseMissing('stations', [
            'id' => $station->id,
        ]);
    }

    public function testItDeletesChildCompaniesWhenCompanyIsDeleted()
    {
        $parentCompany = Company::factory()->create();
        $childCompany = Company::factory()->make();
        $childCompany = $parentCompany->children()->save($childCompany);

        $response = $this->deleteJson('/api/companies/' . $parentCompany->id);
        $response->assertStatus(204);

        $this->assertDatabaseMissing('companies', [
            'id' => $childCompany->id,
        ]);
    }
}
