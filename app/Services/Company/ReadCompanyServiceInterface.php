<?php


namespace App\Services\Company;


use App\Company;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReadCompanyServiceInterface
{
    public function listCompanies() : LengthAwarePaginator;

    public function showSingleCompany(int $companyId) : Company;
}
