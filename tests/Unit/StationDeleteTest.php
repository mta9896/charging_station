<?php


namespace Tests\Unit;


use App\Repository\Station\StationRepository;
use App\Services\Station\DeleteStationService;
use App\Station;
use Mockery\MockInterface;
use Tests\TestCase;

class StationDeleteTest extends TestCase
{
    public function testItDeletesStation()
    {
        $stationId = 1;

        $stationRepository = $this->mock(StationRepository::class, function (MockInterface $mock) use ($stationId) {
            $station = $this->mock(Station::class);
            $mock->shouldReceive('getStation')
                ->with($stationId)
                ->once()
                ->andReturn($station);

            $mock->shouldReceive('deleteStation')
                ->with($station)
                ->once();
        });

        $deleteStationService = new DeleteStationService($stationRepository);
        $deleteStationService->deleteStation($stationId);
    }
}
