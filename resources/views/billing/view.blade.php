@php
    $setting = setting();
@endphp
@extends('layouts.master')

@section('title')
{{ __('sentence.View Earning') }}
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"></h1>
   <a onclick="generatePDF()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
           class="fas fa-print fa-sm text-white-50"></i> Print
   </a>
</div>
<div class="row justify-content-center" id="invoice">
   <div class="col-10">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="row">
               @if(Auth()->user()->role == 'admin')
               <div class="col-md-3">
                  <img src="{{ asset($billing->perception->logo ?? '') }}" style="height: 115px;"
                      alt="">
              </div>
              <div class="col-md-6" style="text-align: center;">
                  
                  <h4 style="font-family: Brush Script MT; font-size:35px; color:#2450d3;">
                    {{ $billing->perception->name ?? '' }}</h4>
                <span>{{ $billing->perception->degree ?? '' }}</span><br>
                <span>{{ $billing->perception->address??'' }}</span><br>
                <span>Tel.{{ $billing->perception->tel ?? '' }} Cel.{{ $billing->perception->cel ?? '' }}</span>
              </div>
               @else
              <div class="col-md-3">
                  <img src="{{ asset($setting->logo ?? '') }}" style="height: 115px;"
                      alt="">
              </div>
              <div class="col-md-6" style="text-align: center;">
                  
                  <h4 style="font-family: Brush Script MT; font-size:35px; color:#2450d3;">
                    {{ $setting->name ?? '' }}</h4>
                <span>{{ $setting->degree ?? '' }}</span><br>
                <span>{{ $setting->address??'' }}</span><br>
                <span>Tel.{{ $setting->tel ?? '' }} Cel.{{ $setting->cel ?? '' }}</span>
              </div>
              @endif
               {{-- <div class="col-md-3">
                   <p>Alger, {{ __('sentence.On') }} {{ $prescription->created_at->format('d-m-Y') }}</p>
               </div> --}}
           </div>
           <hr style="border-top: 2px solid #2450d3; margin-top: 2px;">
            <!-- ROW : Doctor informations -->
            <div class="row">
               <div class="col">
                  {!! clean(App\Setting::get_option('header_left')) !!}
               </div>
               <div class="col-md-4">
                  <p><b>{{ __('sentence.Date') }} :</b> {{ $billing->created_at->format('d-m-Y') }}<br>
                     <b>{{ __('sentence.Time') }} :</b> {{ $billing->created_at->format('h:i A') }}<br>
                     <b>{{ __('sentence.Reference') }} :</b> {{ $billing->reference }}<br>
                     <b>{{ __('sentence.Patient Name') }} :</b> {{ $billing->User->name }}
                  </p>
               </div>
            </div>
            <!-- END ROW : Doctor informations -->
            <!-- ROW : Drugs List -->
            <div class="row justify-content-center">
               <div class="col">
                  <h5 class="text-center"><b>{{ __('sentence.Invoice') }}</b></h5><br>
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th width="10%">#</th>
                           <th width="60%">{{ __('sentence.Item') }}</th>
                           <th width="30%" align="center">{{ __('sentence.Amount') }}</th>
                        </tr>
                     </thead>
                     @forelse ($billing_items as $key => $billing_item)
                     <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $billing_item->invoice_title }}</td>
                        <td align="center">{{ $billing_item->invoice_amount }} {{ App\Setting::get_option('currency') }}</td>
                     </tr>
                     @empty
                     <tr>
                        <td colspan="3">{{ __('sentence.Empty Invoice') }}</td>
                     </tr>
                     @endforelse
                     @empty(!$billing_item)
                     @if(App\Setting::get_option('vat') > 0)
                     <tr style="border-top:2px solid #4444;">
                        <td colspan="2"><strong style="font-size:14px;">{{ __('sentence.Sub-Total') }}</strong></td>
                        <td align="center"><strong>{{ $billing_items->sum('invoice_amount') }}  {{ App\Setting::get_option('currency') }}</strong></td>
                     </tr>
                     <tr>
                        <td colspan="2"><strong>{{ __('sentence.VAT') }}</strong></td>
                        <td align="center"><strong> {{ App\Setting::get_option('vat') }}%</strong></td>
                     </tr>
                     @endif
                     <tr>
                        <td colspan="2"><strong style="font-size:15px;">{{ __('sentence.Total') }}</strong></td>
                        <td align="center"><strong style="font-size:16px;">{{ $billing_items->sum('invoice_amount') + ($billing_items->sum('invoice_amount') * App\Setting::get_option('vat')/100) }}  {{ App\Setting::get_option('currency') }}</strong></td>
                     </tr>
                     @endempty
                  </table>
                  <hr>
               </div>
            </div>
                  <div style="margin-bottom: 250px;"></div>

            <!-- END ROW : Drugs List -->
            <!-- ROW : Footer informations -->
            <div class="row">
               <div class="col">
                  <p class="font-size-12">{!! $setting->footer_left??'' !!}</p>
               </div>
               <div class="col">
                  <p class="float-right font-size-12">{!! $setting->footer_right??'' !!}</p>
               </div>
            </div>
            <!-- END ROW : Footer informations -->
         </div>
      </div>
   </div>
</div>
@endsection

@section('footer')
    <script src="{{ asset('js/pdf.js') }}"></script>
    <script>
        function generatePDF() {
            // Choose the element that our invoice is rendered in.
            const element = document.getElementById('invoice');
            // Choose the element and save the PDF for our user.
            var opt = {
                margin: 0,
                filename: 'report.pdf',
                html2canvas: {
                    scale: 4
                },
                jsPDF: {
                    unit: 'mm',
                    format: [297, 210],
                    orientation: 'p'
                }
            };
            html2pdf()
                .set(opt)
                .from(element)
                .save();
        }
    </script>
    @if ($view == 'print')
        <script>
            generatePDF();
        </script>
    @endif
@endsection