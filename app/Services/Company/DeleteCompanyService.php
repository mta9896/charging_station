<?php


namespace App\Services\Company;


use App\Repository\Company\CompanyRepositoryInterface;

class DeleteCompanyService implements DeleteCompanyServiceInterface
{
    public function __construct(private CompanyRepositoryInterface $companyRepository)
    {
    }

    public function deleteCompany(int $companyId) : void
    {
        $company = $this->companyRepository->getCompany($companyId);

        $this->companyRepository->deleteCompany($company);
    }
}
