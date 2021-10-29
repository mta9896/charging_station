<?php


namespace App\DTO;


class CompanyDTO
{
    public function __construct(private ?string $name = null, private ?int $parentCompanyId = null)
    {
    }

    /**
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getParentCompanyId() : ?int
    {
        return $this->parentCompanyId;
    }
}
