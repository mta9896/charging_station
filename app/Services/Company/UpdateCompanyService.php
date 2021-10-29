<?php


namespace App\Services\Company;


use App\Company;
use App\DTO\CompanyDTO;
use App\Repository\Company\CompanyRepositoryInterface;

class UpdateCompanyService implements UpdateCompanyServiceInterface
{
    public function __construct(private CompanyRepositoryInterface $companyRepository)
    {
    }

    public function updateCompany(CompanyDTO $companyDTO, int $companyId) : Company
    {
        $company = $this->companyRepository->getCompany($companyId);

        $this->companyRepository->updateCompany($company, $companyDTO);

        return $company;
    }
}
