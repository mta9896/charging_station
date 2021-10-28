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
        $company = Company::factory()->create();
        $station = $company->stations()->save(Station::factory()->make());

        $response = $this->getJson('/api/stations/' . $station->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeStation($station),
        ]);
    }

    public function testItReturnsAllStationsWithPagination()
    {
        $companyOne = Company::factory()->create();
        $companyOneStations = $companyOne->stations()->saveMany(Station::factory()->times(10)->make());
        $companyTwo = Company::factory()->create();
        $companyTwoStations = $companyTwo->stations()->saveMany(Station::factory()->times(10)->make());
        $companyThree = Company::factory()->create();
        $companyThreeStations = $companyThree->stations()->saveMany(Station::factory()->times(10)->make());

        $allStations = ($companyOneStations->merge($companyTwoStations))->merge($companyThreeStations);

        $response = $this->getJson('/api/stations');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeStationsArray($allStations->slice(0, 10)),
        ]);

        $response = $this->getJson('/api/stations?page=2');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeStationsArray($allStations->slice(10, 10)),
        ]);

        $response = $this->getJson('/api/stations?page=3');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeStationsArray($allStations->slice(20, 10)),
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

    public function testItReturnsAllStationsWithinRadiusFromAPoint()
    {
        $company = Company::factory()->create();

        $station1 = $company->stations()->save(Station::factory()->make([
            'latitude' => 35.757234,
            'longitude' => 51.403876,
        ])); // 700 meters

        $station2 = $company->stations()->save(Station::factory()->make([
            'latitude' => 35.751693,
            'longitude' => 51.410621,
        ])); // 500 meters

        $company->stations()->save(Station::factory()->make([
            'latitude' => 35.741780,
            'longitude' => 51.402093,
        ])); // 1.01 kilometer

        $station4 = $company->stations()->save(Station::factory()->make([
            'latitude' => 35.743531,
            'longitude' => 51.400763,
        ])); // 850 meters

        $company->stations()->save(Station::factory()->make([
            'latitude' => 35.740493,
            'longitude' => 51.416806,
        ])); // 1.18 kilometers

        $expectedStations = new Collection();
        $expectedStations->push($station2);
        $expectedStations->push($station1);
        $expectedStations->push($station4);

        $latitude = 35.750500;
        $longitude = 51.405250;
        $distance = 1;

        $response = $this->getJson("/api/stations?distance=$distance&latitude=$latitude&longitude=$longitude");
        $response->assertStatus(200);

        $response->assertJson([
            'data' => $this->serializeStationsArray($expectedStations),
        ]);
    }

    public function testItReturnsAllStationsWithNotEnoughFilters()
    {
        $company = Company::factory()->create();
        $company->stations()->saveMany(Station::factory()->times(10)->make());

        $response = $this->getJson("/api/stations?distance=1&latitude=35.23409");
        $response->assertStatus(200);
        $content = json_decode($response->content());
        $this->assertEquals(10, count($content->data));
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
                'id' => $station->company()->first()->id,
                'name' => $station->company()->first()->name,
                'createdAt' => $station->company()->first()->created_at->toAtomString(),
                'updatedAt' => $station->company()->first()->updated_at->toAtomString(),
            ],
        ];
    }
}
