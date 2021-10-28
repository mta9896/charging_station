<?php


namespace Tests\Unit;


use App\DTO\StationDTO;
use App\Repository\Station\StationRepository;
use App\Services\Station\UpdateStationService;
use App\Station;
use Mockery\MockInterface;
use Tests\TestCase;

class StationUpdateTest extends TestCase
{
    public function testItUpdatesStation()
    {
        $stationId = 1;
        $stationDTO = new StationDTO(
            'Station Name',
            35.6677,
            51.45345
        );
        $station = $this->mock(Station::class);

        $stationRepository = $this->mock(StationRepository::class, function (MockInterface $mock) use ($stationDTO, $stationId, $station) {
            $mock->shouldReceive('getStation')
                ->with($stationId)
                ->once()
                ->andReturn($station);

            $mock->shouldReceive('updateStation')
                ->with($stationDTO, $station)
                ->once();
        });

        $updateStationService = new UpdateStationService($stationRepository);
        $updateStationService->updateStation($stationId, $stationDTO);
    }
}
