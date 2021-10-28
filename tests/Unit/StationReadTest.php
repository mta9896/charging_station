<?php


namespace Tests\Unit;


use App\DTO\StationFiltersDTO;
use App\Repository\Station\StationRepository;
use App\Services\Station\ReadStationService;
use Mockery\MockInterface;
use Tests\TestCase;

class StationReadTest extends TestCase
{
    public function testItReturnsAllStationsWhenNoFilterIsGiven()
    {
        $repository = $this->mock(StationRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getStationsList')
                ->once();
        });

        $stationFiltersDTO = new StationFiltersDTO();

        $readStationService = new ReadStationService($repository);
        $readStationService->listStations($stationFiltersDTO);
    }

    public function testItReturnsStationsBasedOnRadiusWhenFiltersAreGiven()
    {
        $repository = $this->mock(StationRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getStationsWithinRadiusFromPoint')
                ->once();
        });

        $stationFiltersDTO = new StationFiltersDTO(
            35.750500,
            51.405250,
            0.8
        );

        $readStationService = new ReadStationService($repository);
        $readStationService->listStations($stationFiltersDTO);
    }

    public function testItReturnsAllStationsByDefaultWhenFiltersAreNotComplete()
    {
        $repository = $this->mock(StationRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getStationsList')
                ->once();
        });

        $stationFiltersDTO = new StationFiltersDTO(
            35.750500,
            51.405250
        );

        $readStationService = new ReadStationService($repository);
        $readStationService->listStations($stationFiltersDTO);
    }

    public function testItReturnsSingleStation()
    {
        $stationId = 1;

        $repository = $this->mock(StationRepository::class, function (MockInterface $mock) use ($stationId) {
            $mock->shouldReceive('getStation')
                ->with($stationId)
                ->once();
        });

        $readStationService = new ReadStationService($repository);
        $readStationService->showSingleStation($stationId);
    }
}
