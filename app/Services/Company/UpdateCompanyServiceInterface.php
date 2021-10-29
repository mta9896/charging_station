<?php


namespace App\Services\Company;


use App\Company;
use App\DTO\CompanyDTO;

interface UpdateCompanyServiceInterface
{
    public function updateCompany(CompanyDTO $companyDTO, int $companyId) : Company;
}
