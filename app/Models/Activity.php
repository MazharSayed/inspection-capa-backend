<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }

    public function subActivities()
    {
        return $this->hasMany(SubActivity::class);
    }
}
