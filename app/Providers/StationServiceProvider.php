<?php


namespace App\Providers;


use App\Repository\Station\StationRepository;
use App\Repository\Station\StationRepositoryInterface;
use App\Services\Station\CreateStationService;
use App\Services\Station\CreateStationServiceInterface;
use App\Services\Station\DeleteStationService;
use App\Services\Station\DeleteStationServiceInterface;
use App\Services\Station\ReadStationService;
use App\Services\Station\ReadStationServiceInterface;
use App\Services\Station\UpdateStationService;
use App\Services\Station\UpdateStationServiceInterface;
use Illuminate\Support\ServiceProvider;

class StationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ReadStationServiceInterface::class, ReadStationService::class);
        $this->app->bind(CreateStationServiceInterface::class, CreateStationService::class);
        $this->app->bind(UpdateStationServiceInterface::class, UpdateStationService::class);
        $this->app->bind(DeleteStationServiceInterface::class, DeleteStationService::class);


        $this->app->bind(StationRepositoryInterface::class, StationRepository::class);
    }
}
