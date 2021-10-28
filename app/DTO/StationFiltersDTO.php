<?php


namespace App\DTO;


class StationFiltersDTO
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $distance;

    public function __construct(float $latitude = null, float $longitude = null, float $distance = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->distance = $distance;
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
