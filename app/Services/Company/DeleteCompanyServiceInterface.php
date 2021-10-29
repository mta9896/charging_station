<?php


namespace App\Services\Company;


interface DeleteCompanyServiceInterface
{
    public function deleteCompany(int $companyId) : void;
}
