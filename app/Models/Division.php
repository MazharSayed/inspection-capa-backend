<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];

    public function subDivisions()
    {
        return $this->hasMany(SubDivision::class);
    }
}
