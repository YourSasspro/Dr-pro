<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    public function clinic()
    {
        return $this->belongsToMany(Clinic::class);
    }
}
