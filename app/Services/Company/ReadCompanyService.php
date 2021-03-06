<?php


namespace App\Services\Company;


use App\Company;
use App\Repository\Company\CompanyRepositoryInterface;
use Illuminate\Support\Collection;

class ReadCompanyService implements ReadCompanyServiceInterface
{
    public function __construct(private CompanyRepositoryInterface $companyRepository)
    {
    }

    public function listCompanies() : Collection
    {
        return $this->companyRepository->getCompaniesList();
    }

    public function showSingleCompany(int $companyId) : Company
    {
        return $this->companyRepository->getCompany($companyId);
    }
}
