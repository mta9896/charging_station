<?php


namespace App\Repository\Company;

use App\Company;
use App\Constants\PaginationConstants;
use App\DTO\CompanyDTO;
use Illuminate\Support\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function getCompaniesList() : Collection
    {
        $companies = Company::with('parent')
            ->paginate(PaginationConstants::COMPANIES_PAGE_SIZE);

        return new Collection($companies->items());
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

    public function assignCompanyToParent(Company $parentCompany, Company $childCompany) : void
    {
        $parentCompany->children()->save($childCompany);
    }

    public function updateCompany(Company $company, CompanyDTO $companyDTO) : void
    {
        $company->update([
            'name' => $companyDTO->getName(),
        ]);
    }

    public function deleteCompany(Company $company) : void
    {
        $company->delete();
    }

    public function getCompanyDescendantsAndSelfIds(Company $company): Collection
    {
        $companies = Company::descendantsAndSelf($company->id);

        return $companies->pluck('id');
    }
}
