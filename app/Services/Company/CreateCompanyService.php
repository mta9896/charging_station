<?php


namespace App\Services\Company;


use App\Company;
use App\DTO\CompanyDTO;
use App\Repository\Company\CompanyRepositoryInterface;

class CreateCompanyService implements CreateCompanyServiceInterface
{
    public function __construct(private CompanyRepositoryInterface $companyRepository)
    {
    }

    public function createCompany(CompanyDTO $companyDTO) : Company
    {
        $company = $this->companyRepository->createCompany($companyDTO);

        if (!empty($companyDTO->getParentCompanyId())) {
            $parentCompany = $this->companyRepository->getCompany($companyDTO->getParentCompanyId());
            $this->companyRepository->assignCompanyToParent($parentCompany, $company);
        }

        return $company;
    }
}
