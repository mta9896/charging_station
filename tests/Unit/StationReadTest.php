<?php


namespace Tests\Unit;


use App\DTO\StationFiltersDTO;
use App\Repository\Station\StationRepository;
use App\Repository\Station\StationRepositoryInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class StationReadTest extends TestCase
{
    public function testItReturnsAllStationsWhenNoFilterIsGiven()
    {
        $this->instance(StationRepositoryInterface::class, \Mockery::mock(StationRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getStationsList')
                ->once();
        }));

        $readService = $this->app->make('App\Services\Station\ReadStationService');

        $stationFiltersDTO = new StationFiltersDTO();
        $readService->listStations($stationFiltersDTO);
    }

    public function testItReturnsStationsBasedOnRadiusWhenFiltersAreGiven()
    {
        $this->instance(StationRepositoryInterface::class, \Mockery::mock(StationRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getStationsWithinRadiusFromPoint')
                ->once();
        }));

        $readService = $this->app->make('App\Services\Station\ReadStationService');

        $stationFiltersDTO = new StationFiltersDTO(
            35.750500,
            51.405250,
            0.8
        );
        $readService->listStations($stationFiltersDTO);
    }

    public function testItReturnsAllStationsByDefaultWhenFiltersAreNotComplete()
    {
        $this->instance(StationRepositoryInterface::class, \Mockery::mock(StationRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getStationsList')
                ->once();
        }));

        $readService = $this->app->make('App\Services\Station\ReadStationService');

        $stationFiltersDTO = new StationFiltersDTO(
            35.750500,
            51.405250
        );
        $readService->listStations($stationFiltersDTO);
    }
}
