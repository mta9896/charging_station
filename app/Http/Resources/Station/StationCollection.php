<?php

namespace App\Http\Resources\Station;

use App\Http\Resources\Company\CompanyResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $stations = [];
        foreach ($this->collection as $station) {
            $stations [] = [
                'id' => $station->id,
                'name' => $station->name,
                'latitude' => $station->latitude,
                'longitude' => $station->longitude,
                'company' => new CompanyResource($station->company),
            ];
        }
        return [
            'data' => $stations,
        ];
    }
}
