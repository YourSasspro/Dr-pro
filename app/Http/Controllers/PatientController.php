<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Patient;
use App\Prescription;
use App\Appointment;
use App\Billing;
use App\Clinic;
use App\Document;
use App\History;
use Illuminate\Support\Facades\Cache;
use Hash;
use Redirect;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


	public function all()
	{

		if (Auth()->user()->role == 'doctor' || Auth()->user()->role == 'dentist') {
			$doctor_id = Auth()->user()->id;
			$patients = User::where('role', 'patient')->where('doctor_id', $doctor_id)->OrderBy('id', 'DESC')->paginate(10);
		} elseif (Auth()->user()->role == 'sectary') {
			$doctor_id = Auth()->user()->doctor_id;
			$patients = User::where('role', 'patient')->where('doctor_id', $doctor_id)->OrderBy('id', 'DESC')->paginate(10);
		} else {
			$patients = User::where('role', 'patient')->OrderBy('id', 'DESC')->paginate(10);
		}
		return view('patient.all', ['patients' => $patients]);
	}

	public function create()
	{
		if (Auth()->user()->role == 'doctor') {
			$doctor_id = Auth()->user()->id;
			$clinic = Clinic::orderBy('name', 'ASC')->where('doctor_id', $doctor_id)->get();
		} elseif (Auth()->user()->role == 'sectary') {
			$doctor_id = Auth()->user()->doctor_id;
			$clinic = Clinic::orderBy('name', 'ASC')->where('doctor_id', $doctor_id)->get();
		} else {
			$clinic = Clinic::orderBy('name', 'ASC')->get();
		}
		return view('patient.create', compact('clinic'));
	}

	public function edit($id)
	{
		$patient = User::find($id);
		$clinic = Clinic::orderBy('name', 'ASC')->get();
		return view('patient.edit', ['patient' => $patient, 'clinic' => $clinic]);
	}

	public function store_edit(Request $request)
	{

		$validatedData = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			// 'email' => [
			// 	'required', 'email', 'max:255',
			// 	Rule::unique('users')->ignore($request->user_id),
			// ],
			'birthday' => ['required'],
			'gender' => ['required'],
			'clinic' => ['required'],

		]);

		$user = User::find($request->user_id);
		$user->name = $request->name;
		$user->update();

		$patient = Patient::where('user_id', $request->user_id)
			->update([
				'birthday' => $request->birthday,
				'phone' => $request->phone,
				'gender' => $request->gender,
				'blood' => $request->blood,
				'adress' => $request->adress,
				'weight' => $request->weight,
				'height' => $request->height,
				'clinic_id' => $request->clinic,
				'patient_id' => $request->id,
				'ars' => $request->ars ?? '',
				'afiliado' => $request->afiliado ?? '',

			]);




		return Redirect::route('patient.all')->with('success', __('sentence.Patient Updated Successfully'));
	}

	public function store(Request $request)
	{

		$validatedData = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			// 'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
			'birthday' => ['required'],
			'gender' => ['required'],
			'clinic' => ['required'],

		]);
		if (Auth()->user()->role == 'doctor') {
			$doctor_id = Auth()->user()->id;
		} elseif (Auth()->user()->role == 'sectary') {
			$doctor_id = Auth()->user()->doctor_id;
		} else {
			$clinic = Clinic::find($request->clinic);
			$doctor_id = $clinic->doctor_id;
		}
		$user = new User();
		$user->password = Hash::make('doctorino123');
		$randomNumber = rand(1, 9999);
		$user->email = 'patient' . $randomNumber . '@publisoft.com';
		$user->name = $request->name;
		$user->doctor_id = $doctor_id;
		$user->save();


		$patient = new Patient();
		$patient->user_id = $user->id;
		$patient->birthday = $request->birthday;
		$patient->phone = $request->phone;
		$patient->gender = $request->gender;
		$patient->blood = $request->blood;
		$patient->adress = $request->adress;
		$patient->weight = $request->weight;
		$patient->height = $request->height;
		$patient->clinic_id = $request->clinic;
		$patient->patient_id = $request->id;
		$patient->ars = $request->ars ?? '';
		$patient->afiliado = $request->afiliado ?? '';
		$patient->save();

		return Redirect::route('patient.all')->with('success', __('sentence.Patient Created Successfully'));
	}


	public function view($id)
	{

		$patient = User::findOrfail($id);
		$prescriptions = Prescription::where('user_id', $id)->OrderBy('id', 'Desc')->get();
		$appointments = Appointment::where('user_id', $id)->OrderBy('id', 'Desc')->get();
		$documents = Document::where('user_id', $id)->OrderBy('id', 'Desc')->get();
		$invoices = Billing::where('user_id', $id)->OrderBy('id', 'Desc')->get();
		$historys = History::where('user_id', $id)->OrderBy('id', 'Desc')->get();
		$doctor = User::findOrfail($patient->doctor_id);
		$clinic = Clinic::where('doctor_id', $doctor->id)->first();

		return view('patient.view', compact(
			'patient',
			'prescriptions',
			'appointments',
			'invoices',
			'documents',
			'historys',
			'doctor',
			'clinic'
		));
	}
}
