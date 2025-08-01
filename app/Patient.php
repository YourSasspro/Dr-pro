<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
	protected $table = 'patients';

	public function clinic_name()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
    public function user_name()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
