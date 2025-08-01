@extends('layouts.master')

@section('title')
{{ __('sentence.Billing List') }}
@endsection

@section('content')

<!-- DataTables  -->
<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="row">
         <div class="col-8">
            <h6 class="m-0 font-weight-bold text-primary w-75 p-2">{{ __('sentence.Billing List') }}</h6>
         </div>
         <div class="col-4">
            <a href="{{ route('billing.create') }}" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> {{ __('sentence.Create Invoice') }}</a>
         </div>
      </div>
   </div>
   <div class="card-body">
      <form action="{{route('billing.filter')}}" method="GET">
         @csrf
         <div class="row mb-3">
            <div class="col-md-5">
               <input type="date" class="form-control" name="start" placeholder="Select Start Date">
            </div>
            <div class="col-md-5">
               <input type="date" class="form-control" name="end" placeholder="Select End Date">
            </div>
            <div class="col-md-2">
               <button class="btn btn-primary">Filter</button>
            </div>
         </div>
      </form>
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>{{ __('sentence.Patient') }}</th>
                  <th>{{ __('sentence.Date') }}</th>
                  <th>{{ __('sentence.Amount') }} - <font class="text-danger">Due Balance</font></th>
                  <th>{{ __('sentence.Status') }}</th>
                  <th>{{ __('sentence.Payment Method') }}</th>
                  <th>{{ __('sentence.Actions') }}</th>
               </tr>
            </thead>
            <tbody>
               @foreach($invoices as $invoice)
               <tr>
                  <td>{{ $invoice->id }}</td>
                  <td><a href="{{ url('patient/view/'.$invoice->user_id) }}"> {{ $invoice->User->name }} </a></td>
                  <td>{{ $invoice->created_at->format('d M Y') }}</td>
                  <td> {{ $invoice->total_with_tax }} {{ App\Setting::get_option('currency') }} 
                     @if($invoice->payment_status == 'Unpaid' OR $invoice->payment_status == 'Partially Paid')
                     <label class="badge badge-danger-soft">{{ $invoice->due_amount }} {{ App\Setting::get_option('currency') }} </label>
                     @endif
                  </td>
                  <td>
                     @if($invoice->payment_status == 'Unpaid')
                     <label class="badge badge-danger-soft">
                     <i class="fas fa-hourglass-start"></i> {{ __('sentence.Unpaid') }}
                     </label>
                     @elseif($invoice->payment_status == 'Paid')
                     <label class="badge badge-success-soft">
                        <i class="fas fa-check"></i> {{ __('sentence.Paid') }}
                     </label>
                     @elseif($invoice->payment_status == 'Partially Paid')
                     <label class="badge badge-warning-soft">
                        <i class="fas fa-hourglass-start"></i> {{ __('sentence.Partially Paid') }}
                     </label>
                     @else
                     
                     @endif
                  </td>
                  <td><label class="badge badge-primary-soft"><i class="fa fa-handshake"></i> {{ $invoice->payment_mode }}</label></td>
                  <td>
                     <a href="{{ url('billing/view/'.$invoice->id) }}" class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-eye"></i></a>
                     <a href="{{ url('billing/pdf/'.$invoice->id) }}" class="btn btn-outline-primary btn-circle btn-sm"><i class="fas fa-print"></i></a>
                     <a href="{{ url('billing/edit/'.$invoice->id) }}" class="btn btn-outline-warning btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                     <a data-toggle="modal" data-target="#DeleteModal" data-link="{{ url('billing/delete/'.$invoice->id) }}" class="btn btn-outline-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         <span class="float-right mt-3">{{ $invoices->links() }}</span>

      </div>
   </div>
</div>
@endsection