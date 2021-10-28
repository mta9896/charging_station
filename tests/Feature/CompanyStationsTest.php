<?php


namespace Tests\Feature;


use App\Company;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CompanyStationsTest extends TestCase
{
    use DatabaseMigrations;

    public function testItReturnsAllStationInTreeForParentCompany()
    {
        $parentCompany = Company::factory()->create();
        $stations = $parentCompany->stations()->saveMany(Station::factory()->times(2)->make());

        $childrenCompanies = $parentCompany->children()->saveMany(Company::factory()->times(2)->make());

        ($childrenCompanies[0])->children()->saveMany(Company::factory()->times(3)->make());
        $childStations1 = ($childrenCompanies[0])->stations()->saveMany(Station::factory()->times(3)->make());

        ($childrenCompanies[1])->children()->saveMany(Company::factory()->times(2)->make());
        $childStations2 = ($childrenCompanies[1])->stations()->saveMany(Station::factory()->times(3)->make());

        $expectedStations = ($stations->merge($childStations1))->merge($childStations2);

        $response = $this->getJson('/api/companies/'.$parentCompany->id.'/stations');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeStationsArray($expectedStations),
        ]);
    }

    public function testItReturnsAllStationsForNonParentCompany()
    {
        $parentCompany = Company::factory()->create();
        $parentCompany->stations()->saveMany(Station::factory()->times(2)->make());

        $childCompaniesLevel1 = $parentCompany->children()->saveMany(Company::factory()->times(2)->make());

        ($childCompaniesLevel1[0])->children()->saveMany(Company::factory()->times(3)->make());
        $childStations1 = ($childCompaniesLevel1[0])->stations()->saveMany(Station::factory()->times(3)->make());

        ($childCompaniesLevel1[1])->children()->saveMany(Company::factory()->times(2)->make());
        ($childCompaniesLevel1[1])->stations()->saveMany(Station::factory()->times(3)->make());

        $childCompaniesLevel2 = ($childCompaniesLevel1[0])->children()->saveMany(Company::factory()->times(2)->make());
        $childStations3 = ($childCompaniesLevel2[0])->stations()->saveMany(Station::factory()->times(4)->make());

        $expectedStations = $childStations1->merge($childStations3);

        $response = $this->getJson('/api/companies/'.($childCompaniesLevel1[0])->id.'/stations');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => $this->serializeStationsArray($expectedStations),
        ]);

    }

    public function testItReturnsNotFoundWhenCompanyDoesntExist()
    {
        $response = $this->getJson('/api/companies/1000/stations');

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
        ];
    }
}
