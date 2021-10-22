<?php


namespace App\Repository\Company;


use App\Company;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface
{
    public function getCompaniesList() : Collection;

    public function getCompany(int $companyId) : Company;
}
