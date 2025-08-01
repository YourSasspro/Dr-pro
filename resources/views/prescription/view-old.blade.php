
<style>
    .d-box{
        width: 8.268in;
        height: 5.293in;
        margin:0 auto;
        display:table;
    }
    .border_bottom_1px{
        border-bottom:1px solid rgb(36, 80, 211);
        border-bottom-width: initial;
    }
    .border_top_1px{
        border-top:1px solid rgb(36, 80, 211);
        border-top-width: initial;
    }
    .invoices{
        position:relative;
        padding-right: 10px;
    }
    .invoices .title{
        font-family: Brush Script MT; font-size:35px; color:rgb(36, 80, 211);
    }
</style>
@php
    $setting = Setting();
@endphp
@extends('layouts.master')

@section('title')
    {{ __('sentence.View Prescription') }}
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
                    <!-- ROW : Doctor informations -->
                    <div class="row" style="border-bottom:5px solid #2450d3;">
                        <div class="col-md-3">
                            <img src="{{ asset($setting->logo ?? '') }}"
                                style="height: 115px;" alt="">
                        </div>
                        <div class="col-md-6" style="text-align: center;">
                            <h4 style="font-family: Brush Script MT; font-size:35px; color:#2450d3;">
                                {{ $setting->name ?? '' }}</h4>
                            <span>{{ $setting->degree ?? '' }}</span><br>
                            <span>{{ $setting->address ?? '' }}</span><br>
                            <span>Tel.{{ $setting->tel ?? '' }}
                                Cel.{{ $setting->cel ?? '' }}</span>

                        </div>
                        {{-- <div class="col-md-3">
                  <p>Alger, {{ __('sentence.On') }} {{ $prescription->created_at->format('d-m-Y') }}</p>
               </div> --}}
                    </div>
                    <!-- END ROW : Doctor informations -->
                    <!-- ROW : Patient informations -->
                    <div class="row" style="margin-top: 10px;">
                        <div class="col">
                            <p>
                                <b>{{ __('sentence.Patient Name') }} :</b> {{ $prescription->User->name }}
                                @isset($prescription->User->Patient->birthday)
                                    - <b>{{ __('sentence.Age') }} :</b> {{ $prescription->User->Patient->birthday }}
                                    ({{ \Carbon\Carbon::parse($prescription->User->Patient->birthday)->age }} Years)
                                @endisset
                                <span>-<b>{{ __('sentence.Date') }}:</b>
                                    {{ Carbon\Carbon::today()->format('m-d-Y') }}</span>
                                {{-- @isset($prescription->User->Patient->weight)
                                    - <b>{{ __('sentence.Patient Weight') }} :</b>
                                    {{ $prescription->User->Patient->weight }} Kg
                                @endisset
                                @isset($prescription->User->Patient->height)
                                    - <b>{{ __('sentence.Patient Height') }} :</b>
                                    {{ $prescription->User->Patient->height }}
                                @endisset --}}
                            </p>
                            <hr>
                        </div>
                    </div>
                    <!-- END ROW : Patient informations -->
                    @if (count($prescription_drugs) > 0)
                        <!-- ROW : Drugs List -->
                        <div class="row justify-content-center" style="min-height: 200px;">
                            <div class="col">
                                @foreach ($prescription_drugs as $drug)
                                    <li>{{ $drug->type }} - {{ $drug->Drug->trade_name }} {{ $drug->strength }} -
                                        {{ $drug->dose }} - {{ $drug->duration }} <br> {{ $drug->drug_advice }}
                                    </li>
                                    @if ($loop->last)
                                        <div style="margin-bottom: 150px;"></div>
                                        <hr>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    @endif
                    
                    @if (count($prescription_tests) > 0)
                        <!-- ROW : Tests List -->
                        <div class="row justify-content-center" style="min-height: 200px;">
                            <div class="col">
                                <strong><u>{{ __('sentence.Test to do') }} </u></strong><br><br>
                                @foreach ($prescription_tests as $test)
                                    <li>{{ $test->Test->test_name }} @empty(!$test->description)
                                            - {{ $test->description }}
                                        @endempty
                                    </li>
                                @endforeach
                            </div>
                        </div>
                        <!-- END ROW : Tests List -->
                    @endif
                    @if (count($prescription_certificate) > 0)
                        <!-- ROW : Tests List -->
                        <div class="row justify-content-center" style="min-height: 200px;">
                            <div class="col">
                                <strong><u>{{ __('sentence.Certificate') }} </u></strong><br><br>
                                @foreach ($prescription_certificate as $item)
                                    <li>{{ $item->description }}</li>
                                    @if ($loop->last)
                                        <div style="margin-bottom: 150px;"></div>
                                        <hr>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <!-- END ROW : Tests List -->
                    @endif
                    <!-- ROW : Footer informations -->
                    <div class="row" style="border-top:3px solid #2450d3;">
                        <div class="col-md-6">
                            <b style="color:#2450d3; font-size:18px;">{!! $setting->footer_left??'' !!}</b>
                        </div>
                        <div class="col-md-6" style="text-align: center;">
                            <span class="float-right" style="color:#2450d3; font-size:14px;">{!! $setting->footer_right??'' !!}</span>
                        </div>
                    </div>
                    <!-- END ROW : Footer informations -->
                </div>
            </div>
            <!---->
            {{-- <div class="col-md-3">
                <p>Alger, {{ __('sentence.On') }} {{ $prescription->created_at->format('d-m-Y') }}</p>
            </div> --}}
            
        </div>
        <!---->
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
