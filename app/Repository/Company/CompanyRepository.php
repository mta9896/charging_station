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

    public function updateCompany(Company $company, CompanyDTO $companyDTO)
    {
        $company->update([
            'name' => $companyDTO->getName(),
        ]);
    }

    public function deleteCompany(Company $company)
    {
        $company->delete();
    }

    public function getCompanyDescendantsAndSelf(Company $company): Collection
    {
        return Company::descendantsAndSelf($company->id);
    }
}
