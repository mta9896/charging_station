<?php


namespace App\Providers;


use App\Repository\Station\StationRepository;
use App\Repository\Station\StationRepositoryInterface;
use App\Services\Station\CreateStationService;
use App\Services\Station\CreateStationServiceInterface;
use App\Services\Station\ReadStationService;
use App\Services\Station\ReadStationServiceInterface;
use Illuminate\Support\ServiceProvider;

class StationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ReadStationServiceInterface::class, ReadStationService::class);
        $this->app->bind(CreateStationServiceInterface::class, CreateStationService::class);


        $this->app->bind(StationRepositoryInterface::class, StationRepository::class);
    }
}
