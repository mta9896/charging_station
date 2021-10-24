<?php


namespace Tests\Integration;


use App\Company;
use App\Repository\Company\CompanyRepository;
use App\Repository\Station\StationRepository;
use App\Services\Station\StationsInCompanyTreeService;
use App\Station;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyStationsTest extends TestCase
{
    use DatabaseMigrations;

    private $stationsInCompanyTreeTest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stationsInCompanyTreeTest = new StationsInCompanyTreeService(new StationRepository(), new CompanyRepository());
    }

    public function testItReturnsAllStationsInTreeForParentCompany()
    {
        $parentCompany = factory(Company::class)->create();
        $childCompanyLevel1 = factory(Company::class)->create([
            'parent_id' => $parentCompany->id,
        ]);
        $childCompanyLevel2 = factory(Company::class)->create([
            'parent_id' => $childCompanyLevel1->id,
        ]);

        factory(Station::class)->times(3)->create([
            'company_id' => $parentCompany->id,
        ]);
        factory(Station::class)->times(2)->create([
            'company_id' => $childCompanyLevel1->id,
        ]);
        factory(Station::class)->times(4)->create([
            'company_id' => $childCompanyLevel2->id,
        ]);

        $allStations = $this->stationsInCompanyTreeTest->getAllCompanyStations($parentCompany->id);

        $this->assertEquals(9, $allStations->count());
    }

    public function testItReturnsAllStationsInTreeForChildCompany()
    {
        $parentCompany = factory(Company::class)->create();
        $childCompanyLevel1 = factory(Company::class)->create([
            'parent_id' => $parentCompany->id,
        ]);
        $childCompanyLevel2 = factory(Company::class)->create([
            'parent_id' => $childCompanyLevel1->id,
        ]);

        factory(Station::class)->times(6)->create([
            'company_id' => $parentCompany->id,
        ]);
        factory(Station::class)->times(2)->create([
            'company_id' => $childCompanyLevel1->id,
        ]);
        factory(Station::class)->times(3)->create([
            'company_id' => $childCompanyLevel2->id,
        ]);

        $allStations = $this->stationsInCompanyTreeTest->getAllCompanyStations($childCompanyLevel1->id);

        $this->assertEquals(5, $allStations->count());
    }

    public function testItDoesNotReturnStationsNotInTree()
    {
        $parentCompany = factory(Company::class)->create();
        $childCompaniesLevel1 = factory(Company::class)->times(2)->create([
            'parent_id' => $parentCompany->id,
        ]);
        $childCompanyLevel2 = factory(Company::class)->create([
            'parent_id' => ($childCompaniesLevel1[0])->id,
        ]);

        factory(Station::class)->times(3)->create([
            'company_id' => $parentCompany->id,
        ]);
        factory(Station::class)->times(2)->create([
            'company_id' => ($childCompaniesLevel1[0])->id,
        ]);
        factory(Station::class)->times(2)->create([
            'company_id' => ($childCompaniesLevel1[1])->id,
        ]);
        factory(Station::class)->times(4)->create([
            'company_id' => $childCompanyLevel2->id,
        ]);

        $allStations = $this->stationsInCompanyTreeTest->getAllCompanyStations(($childCompaniesLevel1[0])->id);

        $this->assertEquals(6, $allStations->count());
    }
}
