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

    public function testItReturnsAllStationsWithinRadiusFromAPoint()
    {
        $company = factory(Company::class)->create();

        $station1 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.757234,
            'longitude' => 51.403876,
        ])); // 700 meters

        $station2 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.751693,
            'longitude' => 51.410621,
        ])); // 500 meters

        $station3 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.741780,
            'longitude' => 51.402093,
        ])); // 1.01 kilometer

        $station4 = $company->stations()->save(factory(Station::class)->make([
            'latitude' => 35.743531,
            'longitude' => 51.400763,
        ])); // 800 meters

        $station5 = $company->stations()->save(factory(Station::class)->make([
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

        $response = $this->getJson("/api/stations/list/point?distance=$distance&latitude=$latitude&longitude=$longitude");
        $response->assertStatus(200);

        $response->assertJson([
            'data' => $this->serializeStationsArray($expectedStations),
        ]);
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
