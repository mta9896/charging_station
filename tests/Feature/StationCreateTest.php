<?php


namespace Tests\Feature;


use App\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StationCreateTest extends TestCase
{
    use DatabaseMigrations;

    public function testItCreatesStation()
    {
        $company = Company::factory()->create();

        $data = [
            'station' => [
                'name' => 'New Station',
                'latitude' => 35.33333,
                'longitude' => 51.99999,
                'companyId' => $company->id,
            ]
        ];

        $response = $this->postJson('/api/stations', $data);
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' =>  'New Station',
                'latitude' => 35.33333,
                'longitude' => 51.99999,
                'company' => [
                    'id' => $company->id,
                    'name' => $company->name,
                ]
            ]
        ]);
    }

    public function testItThrows404WhenCompanyDoesntExist()
    {
        $data = [
            'station' => [
                'name' => 'New Station',
                'latitude' => 35.33333,
                'longitude' => 51.99999,
                'companyId' => 111,
            ]
        ];

        $response = $this->postJson('/api/stations', $data);
        $response->assertStatus(404);
    }

    public function testItThrowsErrorWhenCompanyIdIsAbsent()
    {
        $data = [
            'station' => [
                'name' => 'New Station',
                'latitude' => 23.4444,
                'longitude' => 23.555,
            ]
        ];

        $response = $this->postJson('/api/stations', $data);
        $response->assertStatus(422);
    }
}
