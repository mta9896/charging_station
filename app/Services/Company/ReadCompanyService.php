<?php


namespace App\Services\Company;


use App\Company;
use App\Repository\Company\CompanyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReadCompanyService implements ReadCompanyServiceInterface
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function listCompanies() : LengthAwarePaginator
    {
        return $this->companyRepository->getCompaniesList();
    }

    public function showSingleCompany(int $companyId) : Company
    {
        return $this->companyRepository->getCompany($companyId);
    }
}
