<?php


namespace App\Repository\Company;

use App\Company;
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
}
