<?php


namespace Tests\Feature;


use App\Company;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StationDeleteTest extends TestCase
{
    use DatabaseMigrations;

    public function testItDeletesTheStation()
    {
        $company = factory(Company::class)->create();
        $station = $company->stations()->save(factory(Station::class)->make());

        $response = $this->deleteJson('/api/stations/' . $station->id);
        $response->assertStatus(200);

        $response = $this->getJson('/api/stations/' . $station->id);
        $response->assertStatus(404);

    }
}
