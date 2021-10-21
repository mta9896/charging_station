<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model implements \JsonSerializable
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'createdAt' => $this->created_at->toAtomString(),
            'updatedAt' => $this->updated_at->toAtomString(),
            'company' => $this->company()->get(),
        ];
    }
}
