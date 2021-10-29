<?php


namespace App\DTO;


class StationFiltersDTO
{
    public function __construct(private ?float $latitude = null, private ?float $longitude = null, private ?float $distance = null)
    {
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
     * @return float
     */
    public function getDistance() : ?float
    {
        return $this->distance;
    }
}
