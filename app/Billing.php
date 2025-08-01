<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{

	protected $table = 'billings';

    public function User(){
    	        return $this->belongsTo(User::class, 'user_id');
    }

    
      public function Items(){
    	        return $this->hasMany('App\Billing_item');
    }
    public function doctor_name()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function perception()
    {
        return $this->belongsTo(PreceiptionSetting::class, 'doctor_id','doctor_id');
    }
}
