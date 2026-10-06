<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDivision extends Model
{
    protected $guarded = [];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
