<?php


namespace App\Repository\Company;


use App\Company;
use App\DTO\CompanyDTO;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface
{
    public function getCompaniesList() : Collection;

    public function getCompany(int $companyId) : Company;

    public function createCompany(CompanyDTO $companyDTO) : Company;

    public function assignCompanyToParent(Company $parentCompany, Company $childCompany);
}
