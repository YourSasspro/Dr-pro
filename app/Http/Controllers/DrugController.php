<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Drug;
use App\User;
use Redirect;
class DrugController extends Controller{


	public function __construct(){
        $this->middleware('auth');
    }


    //
    public function create(){
        $doctor = null;
        if(Auth()->user()->role=='admin'){
            $doctor = User::orWhere('role','=','doctor')->orWhere('role','=','dentist')->get();
        }
    	return view('drug.create',compact('doctor'));

    }

    public function store(Request $request){
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
            $doctor_id = Auth()->user()->id;
          } elseif (Auth()->user()->role == 'sectary') {
            $doctor_id = Auth()->user()->doctor_id;
          }else{
            $doctor_id = $request->doctor;
          }
    	$validatedData = $request->validate([
        	'trade_name' => 'required',
        	'generic_name' => 'required',
    	]);

    	$drug = Drug::updateOrCreate(
		    ['trade_name' => $request->trade_name, 'generic_name' => $request->generic_name],
		    ['note' => $request->note,'doctor_id'=>$doctor_id,'create_by', Auth()->user()->id]
		);

    	return Redirect::route('drug.all')->with('success', __('sentence.Drug added Successfully'));
    }

    public function all(){
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
            $doctor_id = Auth()->user()->id;
            $drugs = Drug::where('doctor_id',$doctor_id)->get();
          } elseif (Auth()->user()->role == 'sectary') {
            $doctor_id = Auth()->user()->doctor_id;
            $drugs = Drug::where('doctor_id',$doctor_id)->get();
          }else{
            $drugs = Drug::all();
          }

    	return view('drug.all',['drugs' => $drugs]);
    }


    public function edit($id){
        $drug = Drug::find($id);
        $doctor = null;
        if(Auth()->user()->role=='admin'){
            $doctor = User::orWhere('role','=','doctor')->orWhere('role','=','dentist')->get();
        }
        return view('drug.edit',compact('drug','doctor'));
    }

    public function store_edit(Request $request){
            
        $validatedData = $request->validate([
            'trade_name' => 'required',
            'generic_name' => 'required',
        ]);
        
        $drug = Drug::find($request->drug_id);

        $drug->trade_name = $request->trade_name;
        $drug->generic_name = $request->generic_name;

        $drug->save();

        return Redirect::route('drug.all')->with('success', __('sentence.Drug Edited Successfully'));

    }

        public function destroy($id){

        Drug::destroy($id);
        return Redirect::route('drug.all')->with('success', __('sentence.Drug Deleted Successfully'));

    }
}
