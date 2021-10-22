<?php


namespace App\Repository\Company;

use App\Company;
use App\DTO\CompanyDTO;
use Illuminate\Support\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function getCompaniesList() : Collection
    {
        return Company::with('parent')->get();
    }

    public function getCompany(int $companyId) : Company
    {
        return Company::findOrFail($companyId);
    }

    public function createCompany(CompanyDTO $companyDTO): Company
    {
        $company = Company::create([
            'name' => $companyDTO->getName(),
        ]);

        return $company;
    }

    public function assignCompanyToParent(Company $parentCompany, Company $childCompany)
    {
        $parentCompany->children()->save($childCompany);
    }
}
