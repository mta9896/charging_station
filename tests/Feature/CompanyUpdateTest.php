<?php


namespace Tests\Feature;


use App\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyUpdateTest extends TestCase
{
    use DatabaseMigrations;

    public function testItUpdatesTheCompany()
    {
        $company = Company::factory()->create();

        $data = [
            'company' => [
                'name' => 'New Company Title',
            ],
        ];

        $response = $this->putJson('/api/companies/' . $company->id, $data);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => 'New Company Title',
            ],
        ]);
    }

    public function testItThrowsNotFoundWhenCompanyDoesntExist()
    {
        $data = [
            'company' => [
                'name' => 'New Company Title',
            ],
        ];

        $response = $this->putJson('/api/companies/10', $data);
        $response->assertStatus(404);
    }

    public function testItThrowsErrorWhenPayloadIsNotValid()
    {
        $company = Company::factory()->create();

        $data = [
            'company' => [
                'name' => '',
            ],
        ];

        $response = $this->putJson('/api/companies/'. $company->id, $data);
        $response->assertStatus(422);
    }
}
