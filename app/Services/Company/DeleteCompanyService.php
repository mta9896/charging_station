<?php


namespace App\Services\Company;


use App\Repository\Company\CompanyRepositoryInterface;

class DeleteCompanyService implements DeleteCompanyServiceInterface
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function deleteCompany(int $companyId) : void
    {
        $company = $this->companyRepository->getCompany($companyId);

        $this->companyRepository->deleteCompany($company);
    }
}
