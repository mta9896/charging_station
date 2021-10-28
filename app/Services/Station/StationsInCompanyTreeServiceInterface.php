<?php


namespace App\Services\Station;


use Illuminate\Support\Collection;

interface StationsInCompanyTreeServiceInterface
{
    public function getAllCompanyStations(int $companyId) : Collection;
}
