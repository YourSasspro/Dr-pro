<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;

use App\Test;
use App\User;

class TestController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    
    public function create(){
        $doctor = null;
        if(Auth()->user()->role=='admin'){
            $doctor = User::orWhere('role','=','doctor')->orWhere('role','=','dentist')->get();
        }
    	return view('test.create',compact('doctor'));
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
	        	'test_name' => 'required',
	    	]);
    	$test = new Test;

        $test->test_name = $request->test_name;
        $test->comment = $request->comment;
        $test->doctor_id = $doctor_id;
        $test->create_by = Auth()->user()->id;

        $test->save();

        return Redirect::route('test.all')->with('success', __('sentence.Test Created Successfully'));

    }

    public function all(){
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
            $doctor_id = Auth()->user()->id;
            $tests = Test::where('doctor_id',$doctor_id)->get();
          } elseif (Auth()->user()->role == 'sectary') {
            $doctor_id = Auth()->user()->doctor_id;
            $tests = Test::where('doctor_id',$doctor_id)->get();
          }else{
            $tests = Test::all();
          }
    	return view('test.all', ['tests' => $tests]);
    }

    public function edit($id){
        $test = Test::find($id);
        $doctor = null;
        if(Auth()->user()->role=='admin'){
            $doctor = User::orWhere('role','=','doctor')->orWhere('role','=','dentist')->get();
        }
        return view('test.edit',compact('test','doctor'));
    }

    public function store_edit(Request $request){
      if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
        $doctor_id = Auth()->user()->id;
      } elseif (Auth()->user()->role == 'sectary') {
        $doctor_id = Auth()->user()->doctor_id;
      }else{
        $doctor_id = $request->doctor;
      }
            $validatedData = $request->validate([
                'test_name' => 'required',
            ]);
        
        $test = Test::find($request->test_id);

        $test->test_name = $request->test_name;
        $test->comment = $request->comment;
        $test->doctor_id = $doctor_id;

        $test->save();

        return Redirect::route('test.all')->with('success', __('sentence.Test Edited Successfully'));

    }

    public function destroy($id){

    	Test::destroy($id);
        return Redirect::route('test.all')->with('success', __('sentence.Test Deleted Successfully'));

    }
}
