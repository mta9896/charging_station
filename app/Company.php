<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function stations() : HasMany
    {
        return $this->hasMany(Station::class);
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Company::class, 'parent_id');
    }

    public function children() : HasMany
    {
        return $this->hasMany(Company::class, 'parent_id');
    }
}
