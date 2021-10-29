<?php


namespace App\DTO;


class CompanyDTO
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $parentCompanyId;

    public function __construct(string $name = null, int $parentCompanyId = null)
    {
        $this->name = $name;
        $this->parentCompanyId = $parentCompanyId;
    }

    /**
     * @return string
     */
    public function getName() : string
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
