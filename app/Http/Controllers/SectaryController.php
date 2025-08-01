<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SectaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth()->user()->role == 'admin') {
            $sectary = User::where('role', 'sectary')->OrderBy('id', 'DESC')->paginate(10);
        } else {
            $sectary = User::where('role', 'sectary')->where('doctor_id', Auth()->user()->id)->OrderBy('id', 'DESC')->paginate(10);
        }
        return view('sectary.index', ['sectary' => $sectary]);
    }

    public function create()
    {
        $doctor = null;
        if(Auth()->user()->role=='admin'){
            $doctor = User::orWhere('role','=','doctor')->orWhere('role','=','dentist')->get();
        }
        return view('sectary.create',compact('doctor'));
    }

    public function edit($id)
    {
        $sectary = User::find($id);
        $doctor = null;
        if(Auth()->user()->role=='admin'){
            $doctor = User::orWhere('role','=','doctor')->orWhere('role','=','dentist')->get();
        }
        return view('sectary.edit', ['sectary' => $sectary,'doctor'=>$doctor]);
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],

        ]);
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role == 'dentist') {
			$doctor_id = Auth()->user()->id;
		} elseif (Auth()->user()->role == 'sectary') {
			$doctor_id = Auth()->user()->doctor_id;
		} else {
			$doctor_id = $request->doctor;
		}
        $user = User::find($id);
        $user->email = $request->email;
        $user->doctor_id = $doctor_id;
        $user->name = $request->name;
        $user->update();



        return redirect('sectary')->with('success', 'Sectary Updated Successfully');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'max:16'],

        ]);
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role == 'dentist') {
			$doctor_id = Auth()->user()->id;
		} elseif (Auth()->user()->role == 'sectary') {
			$doctor_id = Auth()->user()->doctor_id;
		} else {
			$doctor_id = $request->doctor;
		}
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->role = 'sectary';
        $user->doctor_id = $doctor_id;
        $user->save();

        return redirect('sectary')->with('success', 'Sectary created Successfully');
    }


    public function show($id)
    {

        $sectary = User::findOrfail($id);

        return view('sectary.show', [
            'sectary' => $sectary
        ]);
    }
    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return back();
    }
}
