<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Setting;
use App\Billing;
use App\Billing_item;
use App\Clinic;
use App\Patient;
use Redirect;
use PDF;

class BillingController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }


  public function create()
  {
    if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
      $doctor_id = Auth()->user()->id;
    } elseif (Auth()->user()->role == 'sectary') {
      $doctor_id = Auth()->user()->doctor_id;
    }
    if(Auth()->user()->role == 'admin'){
      $patients = User::where('role', 'patient')->get();
    }else{
      $patients = User::where('role', 'patient')->where('doctor_id', $doctor_id)->get();
    }
    

    return view('billing.create', ['patients' => $patients]);
  }


  public function store(Request $request)
  {

    $validatedData = $request->validate([
      'patient_id' => ['required', 'exists:users,id'],
      'payment_mode' => 'required',
      'payment_status' => 'required',
      'invoice_title.*' => 'required',
      'invoice_amount.*' => ['required', 'numeric'],
    ]);

    if ($request->payment_status == 'Paid') {
      $request->due_amount = 0;
      $request->deposited_amount = Collect($request->invoice_amount)->sum() + (Collect($request->invoice_amount)->sum() * Setting::get_option('vat') / 100);
    }


    if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
      $doctor_id = Auth()->user()->id;
    } elseif (Auth()->user()->role == 'sectary') {
      $doctor_id = Auth()->user()->doctor_id;
    }else{
      $doctor = User::where('id',$request->patient_id)->first();
      $doctor_id = $doctor->doctor_id;
  }
    $billing = new Billing;

    $billing->user_id = $request->patient_id;
    $billing->payment_mode = $request->payment_mode;
    $billing->payment_status = $request->payment_status;
    $billing->doctor_id = $doctor_id;
    $billing->create_by = Auth()->user()->id;
    $billing->reference = 'b' . rand(10000, 99999);
    $billing->due_amount = $request->due_amount;
    $billing->deposited_amount = $request->deposited_amount;
    $billing->vat = Setting::get_option('vat');
    $billing->total_without_tax = Collect($request->invoice_amount)->sum();
    $billing->total_with_tax = Collect($request->invoice_amount)->sum() + (Collect($request->invoice_amount)->sum() * Setting::get_option('vat') / 100);
    $billing->save();


    if (empty($request->invoice_title)) {
      return Redirect::back()->with('danger', 'Empty Invoice Details!');
    }

    $i = count($request->invoice_title);


    for ($x = 0; $x < $i; $x++) {

      echo $request->invoice_title[$x];



      $invoice_item = new Billing_item;

      $invoice_item->invoice_title = $request->invoice_title[$x];
      $invoice_item->invoice_amount = $request->invoice_amount[$x];
      $invoice_item->billing_id = $billing->id;

      $invoice_item->save();
    }

    return Redirect::route('billing.all')->with('success', 'Invoice Created Successfully!');;
  }

  public function all()
  {
    if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
      $doctor_id = Auth()->user()->id;
      $invoices = Billing::orderby('id', 'DESC')->where('doctor_id', $doctor_id)->paginate(10);
    } elseif (Auth()->user()->role == 'sectary') {
      $doctor_id = Auth()->user()->doctor_id;
      $invoices = Billing::orderby('id', 'DESC')->where('doctor_id', $doctor_id)->paginate(10);
    }else{
      $invoices = Billing::orderby('id', 'DESC')->paginate(10);
    }
    
    return view('billing.all', ['invoices' => $invoices]);
  }

  public function filter(Request $request)
  {
    if (Auth()->user()->role == 'doctor' || Auth()->user()->role=='dentist') {
      $doctor_id = Auth()->user()->id;
      $invoices = Billing::orderby('id', 'DESC')->where('doctor_id', $doctor_id)->whereBetween('created_at', [$request->start, $request->end])->paginate(10);
    } elseif (Auth()->user()->role == 'sectary') {
      $doctor_id = Auth()->user()->doctor_id;
      $invoices = Billing::orderby('id', 'DESC')->where('doctor_id', $doctor_id)->whereBetween('created_at', [$request->start, $request->end])->paginate(10);
    }else{
      $invoices = Billing::orderby('id', 'DESC')->whereBetween('created_at', [$request->start, $request->end])->paginate(10);
      
    }
    
    return view('billing.all', ['invoices' => $invoices]);
  }
  public function view($id)
  {
    if(Auth()->user()->role == 'admin'){
      $billing = Billing::with(['perception'])->findOrfail($id);
    }else{
      $billing = Billing::findOrfail($id);
    }
    $patient = Patient::where('user_id',$billing->user_id)->first();
    $clinic = Clinic::findOrfail($patient->clinic_id);
    $billing_items = Billing_item::where('billing_id', $id)->get();
    $view = 'normal';
    return view('billing.view', compact('billing','billing_items','clinic','view'));
  }

  public function pdf($id)
  {
    if(Auth()->user()->role == 'admin'){
      $billing = Billing::with(['perception'])->findOrfail($id);
    }else{
      $billing = Billing::findOrfail($id);
    }
    
    $patient = Patient::where('user_id',$billing->user_id)->first();
    $clinic = Clinic::findOrfail($patient->clinic_id);
    $billing_items = Billing_item::where('billing_id', $id)->get();
    $view = 'normal';
    
    return view('billing.pdf_view', compact('billing','billing_items','clinic','view'));
    // view()->share(['billing' => $billing, 'billing_items' => $billing_items]);
    // $pdf = PDF::loadView('billing.pdf_view', ['billing' => $billing, 'billing_items' => $billing_items]);

    // // download PDF file with download method
    // return $pdf->download($billing->User->name . '_invoice.pdf');
  }


  public function edit($id)
  {

    $billing = Billing::findOrfail($id);
    $billing_items = Billing_item::where('billing_id', $id)->get();

    return view('billing.edit', ['billing' => $billing, 'billing_items' => $billing_items]);
  }

  public function update(Request $request)
  {

    // return $request;

    if (empty($request->invoice_title)) {
      return Redirect::back()->with('danger', 'Empty Invoice Details!');
    }

    $billing = Billing::findOrfail($request->billing_id);
    $billing_items = Billing_item::where('billing_id', $request->billing_id)->pluck('id')->toArray();




    if ($request->has('billing_item_id')) {
      $filtered = $request->billing_item_id;
    } else {
      $filtered = [];
    }

    foreach ($billing_items as $key => $dz) {
      $filtered[] = "$dz";
    }


    $filtered_unique = array_unique($filtered);


    $deleted_items = array_count_values($filtered);

    foreach ($deleted_items as $key => $value)
      if ($value < 2) {
        $new_array[] = $key;

        Billing_item::destroy($key);
      }


    if (isset($request->invoice_title)) :

      $i = count($request->invoice_title);


      for ($x = 0; $x < $i; $x++) {



        if (isset($request->billing_item_id[$x])) {

          Billing_item::where('id', $request->billing_item_id[$x])
            ->update([
              'invoice_title' => $request->invoice_title[$x],
              'invoice_amount' => $request->invoice_amount[$x]
            ]);
        } else {


          $add_item_to_invoice = new Billing_item;

          $add_item_to_invoice->invoice_title = $request->invoice_title[$x];
          $add_item_to_invoice->invoice_amount = $request->invoice_amount[$x];
          $add_item_to_invoice->billing_id = $request->billing_id;

          $add_item_to_invoice->save();
        }
      }

      if ($request->payment_status == 'Paid') {
        $request->due_amount = 0;
        $request->deposited_amount = Collect($request->invoice_amount)->sum() + (Collect($request->invoice_amount)->sum() * Setting::get_option('vat') / 100);
      }

      $billing = Billing::find($request->billing_id);

      $billing->user_id = $request->patient_id;
      $billing->payment_mode = $request->payment_mode;
      $billing->payment_status = $request->payment_status;
      $billing->reference = 'b' . rand(10000, 99999);
      $billing->due_amount = $request->due_amount;
      $billing->deposited_amount = $request->deposited_amount;
      $billing->vat = Setting::get_option('vat');
      $billing->total_without_tax = Collect($request->invoice_amount)->sum();
      $billing->total_with_tax = Collect($request->invoice_amount)->sum() + (Collect($request->invoice_amount)->sum() * Setting::get_option('vat') / 100);
      $billing->save();

    endif;


    return Redirect::route('billing.all')->with('success', 'Invoice Edited Successfully!');;
  }

  public function destroy($id)
  {

    Billing::destroy($id);
    return Redirect::route('billing.all')->with('success', 'Invoice Deleted Successfully!');
  }
}
