<?php


namespace App\Providers;


use App\Repository\Company\CompanyRepository;
use App\Repository\Company\CompanyRepositoryInterface;
use App\Services\Company\CreateCompanyService;
use App\Services\Company\CreateCompanyServiceInterface;
use App\Services\Company\DeleteCompanyService;
use App\Services\Company\DeleteCompanyServiceInterface;
use App\Services\Company\ReadCompanyService;
use App\Services\Company\ReadCompanyServiceInterface;
use App\Services\Company\UpdateCompanyService;
use App\Services\Company\UpdateCompanyServiceInterface;
use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ReadCompanyServiceInterface::class, ReadCompanyService::class);
        $this->app->bind(CreateCompanyServiceInterface::class, CreateCompanyService::class);
        $this->app->bind(UpdateCompanyServiceInterface::class, UpdateCompanyService::class);
        $this->app->bind(DeleteCompanyServiceInterface::class, DeleteCompanyService::class);

        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
    }
}
