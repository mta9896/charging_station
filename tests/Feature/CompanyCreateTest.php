<?php


namespace Tests\Feature;


use App\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyCreateTest extends TestCase
{
    use DatabaseMigrations;

    public function testItCreatesParentCompany()
    {
        $data = [
            'company' => [
                'name' => 'Test Parent Company',
            ],
        ];

        $response = $this->postJson('/api/companies', $data);
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Test Parent Company',
            ],
        ]);
    }

    public function testItCreatesChildCompany()
    {
        $parentCompany = Company::factory()->create();
        $data = [
            'company' => [
                'name' => 'Test Child Company',
                'parentId' => $parentCompany->id,
            ],
        ];

        $response = $this->postJson('/api/companies', $data);
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Test Child Company',
                'parentCompany' => [
                    'id' => $parentCompany->id,
                ]
            ],
        ]);
    }

    public function testItThrowsNotFoundWhenPrentCompanyDoesntExist()
    {
        $data = [
            'company' => [
                'name' => 'Test Child Company',
                'parentId' => 1000,
            ],
        ];

        $response = $this->postJson('/api/companies', $data);
        $response->assertStatus(404);
    }

    public function testItThrowsErrorWhenPayloadIsNotValid()
    {
        $data = [
            'company' => [
                'name' => '',
            ],
        ];

        $response = $this->postJson('/api/companies', $data);
        $response->assertStatus(422);
    }
}
