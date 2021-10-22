<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = [
        'name', 'latitude', 'longitude',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
