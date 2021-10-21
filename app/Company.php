<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model implements \JsonSerializable
{
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
        return $this->belongsTo(Company::class, 'parent_company_id');
    }

    public function children()
    {
        return $this->hasMany(Company::class, 'parent_company_id');
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'createdAt' => $this->created_at->toAtomString(),
            'updatedAt' => $this->updated_at->toAtomString(),
            'parentCompany' => $this->parent()->get(),
        ];
    }
}
