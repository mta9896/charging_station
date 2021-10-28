<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Company extends Model
{
    use NodeTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }

    public function parent()
    {
        return $this->belongsTo(Company::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Company::class, 'parent_id');
    }
}
