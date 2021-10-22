<?php


namespace Tests\Feature;


use App\Company;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StationUpdateTest extends TestCase
{
    use DatabaseMigrations;

    public function testItUpdatesTheStation()
    {
        $company = factory(Company::class)->create();
        $station = $company->stations()->save(factory(Station::class)->make());

        $data = [
            'station' => [
                'name' => 'Updated Station',
                'latitude' => 35.33333,
                'longitude' => 51.99999,
                'companyId' => $company->id,
            ]
        ];

        $response = $this->putJson('/api/stations/' . $station->id, $data);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' =>  'Updated Station',
                'latitude' => 35.33333,
                'longitude' => 51.99999,
                'company' => [
                    [
                        'id' => $company->id,
                        'name' => $company->name,
                    ]
                ]
            ]
        ]);
    }

    public function testItThrows404WhenStationDoesntExist()
    {
        $data = [
            'data' => [
                'name' => 'Updated Station',
                'longitude' => 51.99999,
            ]
        ];

        $response = $this->putJson('/api/stations/123', $data);
        $response->assertStatus(404);
    }
}
