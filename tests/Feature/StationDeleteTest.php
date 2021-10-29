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
        $company = Company::factory()->create();
        $station = $company->stations()->save(Station::factory()->make());

        $response = $this->deleteJson('/api/stations/' . $station->id);
        $response->assertStatus(204);

        $this->assertDatabaseMissing('stations', [
            'id' => $station->id,
        ]);
    }
}
