<?php


namespace App\Services\Company;


use App\Company;
use App\DTO\CompanyDTO;

interface CreateCompanyServiceInterface
{
    public function createCompany(CompanyDTO $companyDTO) : Company;
}
