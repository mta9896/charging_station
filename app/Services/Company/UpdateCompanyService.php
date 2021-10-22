<?php


namespace App\Services\Company;


use App\DTO\CompanyDTO;
use App\Repository\Company\CompanyRepositoryInterface;

class UpdateCompanyService implements UpdateCompanyServiceInterface
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function updateCompany(CompanyDTO $companyDTO, int $companyId)
    {
        $company = $this->companyRepository->getCompany($companyId);

        $this->companyRepository->updateCompany($company, $companyDTO);

        return $company;
    }
}
