<?php


namespace App\DTO;


class StationDTO
{
    public function __construct(private ?string $name = null, private ?float $latitude = null, private ?float $longitude = null, private ?int $companyId = null)
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
     * @return float
     */
    public function getLatitude() : ?float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude() : ?float
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getCompanyId() : ?int
    {
        return $this->companyId;
    }
}
