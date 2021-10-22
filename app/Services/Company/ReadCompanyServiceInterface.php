<?php


namespace App\Services\Company;


use App\Company;
use Illuminate\Support\Collection;

interface ReadCompanyServiceInterface
{
    public function listCompanies() : Collection;

    public function showSingleCompany(int $companyId) : Company;
}
