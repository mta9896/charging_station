<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'latitude', 'longitude',
    ];

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
