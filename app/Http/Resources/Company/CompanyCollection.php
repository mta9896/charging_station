<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $companies = [];
        foreach ($this->collection as $company) {
            $companies [] = [
                'id' => $company->id,
                'name' => $company->name,
                'parentCompany' => new CompanyResource($company->parent),
            ];
        }

        return [
            'data' => $companies,
        ];
    }
}
