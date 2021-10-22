<?php


namespace App\Providers;


use App\Repository\Company\CompanyRepository;
use App\Repository\Company\CompanyRepositoryInterface;
use App\Services\Company\ReadCompanyService;
use App\Services\Company\ReadCompanyServiceInterface;
use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ReadCompanyServiceInterface::class, ReadCompanyService::class);


        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
    }
}
