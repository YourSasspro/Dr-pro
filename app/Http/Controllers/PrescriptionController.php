<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Drug;
use App\User;
use App\Patient;
use App\PreceiptionSetting;
use App\Prescription;
use App\Prescription_drug;
use App\Prescription_test;
use App\PrescriptionCertificate;
use App\Test;
use Redirect;
use PDF;
use Arr;

class PrescriptionController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create()
    {
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role == 'dentist') {
            $doctor_id = Auth()->user()->id;
            $drugs = Drug::where('doctor_id', $doctor_id)->get();
            $patients = User::where('role', 'patient')->where('doctor_id', $doctor_id)->get();
            $tests = Test::where('doctor_id', $doctor_id)->get();
        } elseif (Auth()->user()->role == 'sectary') {
            $doctor_id = Auth()->user()->doctor_id;
            $drugs = Drug::where('doctor_id', $doctor_id)->get();
            $patients = User::where('role', 'patient')->where('doctor_id', $doctor_id)->get();
            $tests = Test::where('doctor_id', $doctor_id)->get();
        } else {
            $drugs = Drug::all();
            $patients = User::where('role', 'patient')->get();
            $tests = Test::all();
        }
        return view('prescription.create', ['drugs' => $drugs, 'patients' => $patients, 'tests' => $tests]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => ['required', 'exists:users,id'],
            'trade_name.*' => 'required',
        ]);



        if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
            $doctor_id = Auth()->user()->id;
        } elseif (Auth()->user()->role == 'sectary') {
            $doctor_id = Auth()->user()->doctor_id;
        }else{
            $user = User::find($request->patient_id);
			$doctor_id = $user->doctor_id;
        }
        $prescription = new Prescription;

        $prescription->user_id = $request->patient_id;
        $prescription->doctor_id = $doctor_id;
        $prescription->create_by = Auth()->user()->id;
        $prescription->reference = 'p' . rand(10000, 99999);

        $prescription->save();


        if (isset($request->trade_name)) :

            $i = count($request->trade_name);

            for ($x = 0; $x < $i; $x++) {

                if ($request->trade_name[$x] != null) {

                    $add_drug = new Prescription_drug;

                    $add_drug->type = $request->type[$x];
                    $add_drug->strength = $request->strength[$x];
                    $add_drug->dose = $request->dose[$x];
                    $add_drug->duration = $request->duration[$x];
                    $add_drug->drug_advice = $request->drug_advice[$x];
                    $add_drug->prescription_id = $prescription->id;
                    $add_drug->drug_id = $request->trade_name[$x];

                    $add_drug->save();
                }
            }
        endif;

        if (isset($request->test_name)) :

            $y = count($request->test_name);

            for ($x = 0; $x < $y; $x++) {

                $add_test = new Prescription_test;

                $add_test->test_id = $request->test_name[$x];
                $add_test->prescription_id = $prescription->id;
                $add_test->description = $request->description[$x];

                $add_test->save();
            }

        endif;
        if (isset($request->p_description)) :

            $y = count($request->p_description);

            for ($x = 0; $x < $y; $x++) {

                $add_certificate = new PrescriptionCertificate;

                $add_certificate->prescription_id = $prescription->id;
                $add_certificate->description = $request->p_description[$x];

                $add_certificate->save();
            }

        endif;

        return Redirect::route('prescription.all')->with('success', 'Prescription Created Successfully!');;
    }

    public function all()
    {
        if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
            $doctor_id = Auth()->user()->id;
            $prescriptions = Prescription::orderBy('id', 'DESC')->where('doctor_id', $doctor_id)->paginate(10);
        } elseif (Auth()->user()->role == 'sectary') {
            $doctor_id = Auth()->user()->doctor_id;
            $prescriptions = Prescription::orderBy('id', 'DESC')->where('doctor_id', $doctor_id)->paginate(10);
        }else{
            $prescriptions = Prescription::orderBy('id', 'DESC')->paginate(10);
        }
        

        return view('prescription.all', ['prescriptions' => $prescriptions]);
    }

    public function view($id)
    {

        $prescription = Prescription::findOrfail($id);
        $prescription_drugs = Prescription_drug::where('prescription_id', $id)->get();
        $prescription_tests = Prescription_test::where('prescription_id', $id)->get();
        $prescription_certificate = PrescriptionCertificate::where('prescription_id', $id)->get();
        $setting  = PreceiptionSetting::where('doctor_id',$prescription->doctor_id)->first();

        return view('prescription.view', ['prescription' => $prescription, 'prescription_drugs' => $prescription_drugs, 'prescription_tests' => $prescription_tests, 'prescription_certificate' => $prescription_certificate, 'view' => 'normal','setting'=>$setting]);
    }
    public function pdf_generate($id)
    {

        $prescription = Prescription::findOrfail($id);
        $prescription_drugs = Prescription_drug::where('prescription_id', $id)->get();
        $prescription_tests = Prescription_test::where('prescription_id', $id)->get();
        $prescription_certificate = PrescriptionCertificate::where('prescription_id', $id)->get();
        $setting  = PreceiptionSetting::where('doctor_id',$prescription->doctor_id)->first();

        //        return view('prescription.pdf_generate', ['prescription' => $prescription, 'prescription_drugs' => $prescription_drugs, 'prescription_tests' => $prescription_tests, 'prescription_certificate' => $prescription_certificate]);
        return view('prescription.view', ['prescription' => $prescription, 'prescription_drugs' => $prescription_drugs, 'prescription_tests' => $prescription_tests, 'prescription_certificate' => $prescription_certificate, 'view' => 'print','setting'=>$setting]);
    }

    public function pdf($id)
    {

        $prescription = Prescription::findOrfail($id);
        $prescription_drugs = Prescription_drug::where('prescription_id', $id)->get();
        $prescription_tests = Prescription_test::where('prescription_id', $id)->get();
        $prescription_certificate = PrescriptionCertificate::where('prescription_id', $id)->get();
        $setting  = PreceiptionSetting::where('doctor_id',$prescription->doctor_id)->first();

        //        view()->share(['prescription' => $prescription, 'prescription_drugs' => $prescription_drugs]);
        //        $pdf = PDF::loadView('prescription.pdf_view', ['prescription' => $prescription, 'prescription_drugs' => $prescription_drugs, 'prescription_tests' => $prescription_tests, 'prescription_certificate' => $prescription_certificate]);
        //
        //        // download PDF file with download method
        //        return $pdf->download($prescription->User->name . '_pdf.pdf');
        return view('prescription.view', ['prescription' => $prescription, 'prescription_drugs' => $prescription_drugs, 'prescription_tests' => $prescription_tests, 'prescription_certificate' => $prescription_certificate, 'view' => 'print','setting'=>$setting]);
    }


    public function edit($id)
    {

        $prescription = Prescription::findOrfail($id);
        $prescription_drugs = Prescription_drug::where('prescription_id', $id)->get();
        $prescription_tests = Prescription_test::where('prescription_id', $id)->get();
        $prescription_certificate = PrescriptionCertificate::where('prescription_id', $id)->get();

        $drugs = Drug::all();
        $tests = Test::all();

        return view('prescription.edit', ['prescription' => $prescription, 'prescription_drugs' => $prescription_drugs, 'prescription_tests' => $prescription_tests, 'drugs' => $drugs, 'tests' => $tests, 'prescription_certificate' => $prescription_certificate]);
    }


    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'patient_id' => ['required', 'exists:users,id'],
            'trade_name.*' => 'required',
        ]);

        $prescription_drugs = Prescription_drug::where('prescription_id', $request->prescription_id)->pluck('id')->toArray();

        if ($request->has('prescription_drug_id')) {
            $filtered = $request->prescription_drug_id;
        } else {
            $filtered = [];
        }

        foreach ($prescription_drugs as $key => $dz) {
            $filtered[] = "$dz";
        }


        $filtered_unique = array_unique($filtered);


        $deleted_drugs = array_count_values($filtered);

        foreach ($deleted_drugs as $key => $value)
            if ($value < 2) {
                $new_array[] = $key;

                Prescription_drug::destroy($key);
            }


        if (isset($request->trade_name)) :

            $i = count($request->trade_name);


            for ($x = 0; $x < $i; $x++) {



                if (isset($request->prescription_drug_id[$x])) {

                    Prescription_drug::where('id', $request->prescription_drug_id[$x])
                        ->update([
                            'type' => $request->type[$x],
                            'strength' => $request->strength[$x],
                            'dose' => $request->dose[$x],
                            'duration' => $request->duration[$x],
                            'drug_advice' => $request->drug_advice[$x],
                            'drug_id' => $request->trade_name[$x]
                        ]);
                } else {
                    $add_drug = new Prescription_drug;

                    $add_drug->type = $request->type[$x];
                    $add_drug->strength = $request->strength[$x];
                    $add_drug->dose = $request->dose[$x];
                    $add_drug->duration = $request->duration[$x];
                    $add_drug->drug_advice = $request->drug_advice[$x];
                    $add_drug->prescription_id = $request->prescription_id;
                    $add_drug->drug_id = $request->trade_name[$x];

                    $add_drug->save();
                }
            }
        endif;

        // Test 

        $prescription_tests = Prescription_test::where('prescription_id', $request->prescription_id)->pluck('id')->toArray();

        if ($request->has('prescription_test_id')) {
            $filtered_test = $request->prescription_test_id;
        } else {
            $filtered_test = [];
        }

        foreach ($prescription_tests as $key => $fr) {
            $filtered_test[] = "$fr";
        }


        $filtered_test_unique = array_unique($filtered_test);


        $deleted_tests = array_count_values($filtered_test);

        foreach ($deleted_tests as $key => $value)
            if ($value < 2) {
                //$new_array[] = $key;
                Prescription_test::destroy($key);
            }


        if (isset($request->test_name)) :

            $i = count($request->test_name);


            for ($x = 0; $x < $i; $x++) {



                if (isset($request->prescription_test_id[$x])) {

                    Prescription_test::where('id', $request->prescription_test_id[$x])
                        ->update([
                            'description' => $request->description[$x],
                            'test_id' => $request->test_name[$x]
                        ]);
                } else {
                    $add_test = new Prescription_test;
                    $add_test->description = $request->description[$x];
                    $add_test->prescription_id = $request->prescription_id;
                    $add_test->test_id = $request->test_name[$x];

                    $add_test->save();
                }
            }
        endif;
        // Certificate 

        $prescription_certificate = PrescriptionCertificate::where('prescription_id', $request->prescription_id)->pluck('id')->toArray();

        if ($request->has('prescription_certificate_id')) {
            $filtered_certificate = $request->prescription_certificate_id;
        } else {
            $filtered_certificate = [];
        }

        foreach ($prescription_certificate as $key => $fr) {
            $filtered_certificate[] = "$fr";
        }


        $filtered_certificate_unique = array_unique($filtered_certificate);


        $deleted_certificates = array_count_values($filtered_certificate);

        foreach ($deleted_certificates as $key => $value)
            if ($value < 2) {
                //$new_array[] = $key;
                PrescriptionCertificate::destroy($key);
            }


        if (isset($request->p_description)) :

            $i = count($request->p_description);


            for ($x = 0; $x < $i; $x++) {



                if (isset($request->prescription_certificate_id[$x])) {

                    PrescriptionCertificate::where('id', $request->prescription_certificate_id[$x])
                        ->update([
                            'description' => $request->description[$x]
                        ]);
                } else {
                    $add_certificate = new PrescriptionCertificate();
                    $add_certificate->description = $request->description[$x];
                    $add_certificate->prescription_id = $request->prescription_id;

                    $add_certificate->save();
                }
            }
        endif;
        return Redirect::route('prescription.view', ['id' => $request->prescription_id])->with('success', 'Prescription Edited Successfully!');;

        //return $request;

    }


    public function destroy($id)
    {

        Prescription::destroy($id);
        return Redirect::route('prescription.all')->with('success', 'Prescription Deleted Successfully!');;
    }
}
