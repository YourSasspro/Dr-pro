<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\User;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index()
    {
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
            $doctor_id = Auth()->user()->id;
            $clinic = Clinic::where('doctor_id',Auth()->user()->id)->OrderBy('id', 'DESC')->paginate(10);
        } elseif (Auth()->user()->role == 'sectary') {
            $doctor_id = Auth()->user()->doctor_id;
            $clinic = Clinic::where('doctor_id',Auth()->user()->id)->OrderBy('id', 'DESC')->paginate(10);
        }else{
            $clinic = Clinic::OrderBy('id', 'DESC')->paginate(10);
        }
        

        return view('clinic.index', ['clinic' => $clinic]);
    }

    public function create()
    {
        $doctor = null;
        if(Auth()->user()->role=='admin'){
            $doctor = User::orWhere('role','=','doctor')->orWhere('role','=','dentist')->get();
        }
        return view('clinic.create',compact('doctor'));
        
    }

    public function edit($id)
    {
        $clinic = Clinic::find($id);
        $doctor = null;
        if(Auth()->user()->role=='admin'){
            $doctor = User::orWhere('role','=','doctor')->orWhere('role','=','dentist')->get();
        }
        return view('clinic.edit', compact('clinic','doctor'));
    }

    public function update(Request $request,$id)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'max:255'],
            'tel' => ['required', 'max:255'],
            'cel' => ['required', 'max:255'],
            'logo' => ['required', 'max:255'],

        ]);
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
            $doctor_id = Auth()->user()->id;
        } elseif (Auth()->user()->role == 'sectary') {
            $doctor_id = Auth()->user()->doctor_id;
        }else{
            $doctor_id = $request->doctor;
        }
        $user = Clinic::find($id);
        if($request->hasfile('logo')){
            $file = $request->file('logo');
            $upload = 'img/';
            $filename = time().$file->getClientOriginalName();
            $path    = move_uploaded_file($file->getPathName(), $upload.$filename);
            $user->logo= $upload.$filename;
        }
        $user->address = $request->address;
        $user->doctor_id = $doctor_id;
        $user->tel = $request->tel;
        $user->cel = $request->cel;
        $user->name = $request->name;
        $user->update();


        
        return redirect('clinic')->with('success','Clinic Updated Successfully');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string','max:255'],
            'tel' => ['required', 'string','max:255'],
            'cel' => ['required', 'string','max:255'],
            'logo' => ['required', 'max:255'],

        ]);
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
            $doctor_id = Auth()->user()->id;
        } elseif (Auth()->user()->role == 'sectary') {
            $doctor_id = Auth()->user()->doctor_id;
        }else{
            $doctor_id = $request->doctor;
        }
        $user = new Clinic;
        if($request->hasfile('logo')){
            $file = $request->file('logo');
            $upload = 'img/';
            $filename = time().$file->getClientOriginalName();
            $path    = move_uploaded_file($file->getPathName(), $upload.$filename);
            $user->logo= $upload.$filename;
        }
        $user->address = $request->address;
        $user->tel = $request->tel;
        $user->cel = $request->cel;
        $user->name = $request->name;
        $user->doctor_id = $doctor_id;
        $user->create_by = Auth()->user()->id;
        $user->save();

        return redirect('clinic')->with('success','Clinic created Successfully');
    }


    public function show($id)
    {

        $clinic = Clinic::findOrfail($id);

        return view('clinic.show', [
            'clinic' => $clinic
        ]);
    }
    public function destroy(Request $request)
    {
        $clinic=Clinic::find($request->id);
        $clinic->delete();
        return back();
    }
}
