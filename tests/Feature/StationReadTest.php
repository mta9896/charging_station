<?php


namespace Tests\Feature;


use App\Company;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class StationReadTest extends TestCase
{
    use DatabaseMigrations;

    public function testItReturnsSingleStation()
    {
        $company = factory(Company::class)->create();
        $station = $company->stations()->save(factory(Station::class)->make());

        $response = $this->getJson('/api/stations/' . $station->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeStation($station),
        ]);
    }

    public function testItReturnsAllStations()
    {
        $companyOne = factory(Company::class)->create();
        $companyOneStations = $companyOne->stations()->saveMany(factory(Station::class)->times(10)->make());
        $companyTwo = factory(Company::class)->create();
        $companyTwoStations = $companyTwo->stations()->saveMany(factory(Station::class)->times(10)->make());
        $companyThree = factory(Company::class)->create();
        $companyThreeStations = $companyThree->stations()->saveMany(factory(Station::class)->times(10)->make());

        $allStations = ($companyOneStations->merge($companyTwoStations))->merge($companyThreeStations);

        $response = $this->getJson('/api/stations');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeStationsArray($allStations),
        ]);
    }

    public function testItReturnsEmptyArrayWhenNoStationsExist()
    {
        $response = $this->getJson('/api/stations');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [],
        ]);
    }

    public function testItReturnsNotFoundWhenStationDoesntExist()
    {
        $response = $this->getJson('/api/stations/1000');

        $response->assertStatus(404);
    }

    private function serializeStationsArray(Collection $stations)
    {
        $result = [];
        foreach ($stations as $station) {
            $result [] = $this->serializeStation($station);
        }

        return $result;
    }

    private function serializeStation(Station $station)
    {
        return [
            'id' => $station->id,
            'name' => $station->name,
            'latitude' => $station->latitude,
            'longitude' => $station->longitude,
            'company' => [
                [
                    'id' => $station->company()->first()->id,
                    'name' => $station->company()->first()->name,
                    'createdAt' => $station->company()->first()->created_at->toAtomString(),
                    'updatedAt' => $station->company()->first()->updated_at->toAtomString(),
                ]
            ],
        ];
    }
}
