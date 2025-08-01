<?php

namespace App\Http\Controllers;

use App\PreceiptionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PreceiptionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = PreceiptionSetting::where('doctor_id',Auth()->user()->id)->first();
        return view('settings/prescription_settings',compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = PreceiptionSetting::where('doctor_id',Auth()->user()->id)->first();
        if($setting!=null){
        if($request->hasfile('logo')){
            $file = $request->file('logo');
            $upload = 'img/';
            $filename = time().$file->getClientOriginalName();
            $path    = move_uploaded_file($file->getPathName(), $upload.$filename);
            $setting->logo=$upload.$filename;
        }
        $setting->name= $request->name;
        $setting->degree= $request->degree;
        $setting->address= $request->address;
        $setting->tel=$request->tel;
        $setting->cel= $request->cel;
        $setting->footer_right= $request->footer_right;
        $setting->footer_left= $request->footer_left;
        
            $setting->update();
        }else{
            $storeSetting = new PreceiptionSetting;
            if($request->hasfile('logo')){
                $file = $request->file('logo');
                $upload = 'img/';
                $filename = time().$file->getClientOriginalName();
                $path    = move_uploaded_file($file->getPathName(), $upload.$filename);
                $storeSetting->logo=$upload.$filename;
            }
            $storeSetting->name= $request->name;
            $storeSetting->degree= $request->degree;
            $storeSetting->address= $request->address;
            $storeSetting->tel=$request->tel;
            $storeSetting->cel= $request->cel;
            $storeSetting->footer_right= $request->footer_right;
            $storeSetting->footer_left= $request->footer_left;
            $storeSetting->doctor_id = Auth()->user()->id;
            $storeSetting->save();
        }

    	return Redirect::route('prescription_settings.edit')->with('success', __("sentence.Settings edited Successfully"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PreceiptionSetting  $preceiptionSetting
     * @return \Illuminate\Http\Response
     */
    public function show(PreceiptionSetting $preceiptionSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreceiptionSetting  $preceiptionSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(PreceiptionSetting $preceiptionSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreceiptionSetting  $preceiptionSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreceiptionSetting $preceiptionSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreceiptionSetting  $preceiptionSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreceiptionSetting $preceiptionSetting)
    {
        //
    }
}
