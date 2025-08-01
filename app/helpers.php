<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function setting(){
    if(Auth()->user()->role=='sectary'){
        $doctor_id = Auth()->user()->doctor_id;
    }elseif(Auth()->user()->role=='doctor' || Auth()->user()->role=='dentist'){
        $doctor_id = Auth()->user()->id;
    }elseif(Auth()->user()->role=='admin'){
        $doctor_id = Auth()->user()->id;
    }
        $setting  = App\PreceiptionSetting::where('doctor_id',$doctor_id)->first();
        return $setting;
    }
?>