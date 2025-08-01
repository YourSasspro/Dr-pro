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
    }
    .invoices .title{
        font-family: Brush Script MT; font-size:35px; color:rgb(36, 80, 211);
    }
</style>

@extends('layouts.master')

@section('title')
    {{ __('sentence.View Prescription') }}
@endsection

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        
    </div>
    <div class="invoices" id="invoice">
    <div class="shadow card-body d-box">
        <div class="row border_bottom_1px d-flex position-relative align-items-start mb-2">
            <div class="col-md-3"><img src="{{ asset($setting->logo ?? '') }}" style="height: 115px;" alt=""></div>
            <div class="col-md-6" style="text-align: center;">
                <h4 class="title">{{ $setting->name ?? '' }}</h4>
                <p class="mb-1">{{ $setting->degree ?? '' }}</p>
                <p class="mb-1">{{ $setting->address ?? '' }}</p>
                <p class="">Tel.{{ $setting->tel ?? '' }}
                                Cel.{{ $setting->cel ?? '' }}</p>
            </div>
            <!---->
            
            <!-- <hr style="border-top: 2px solid #2450d3; margin-top: 2px; position:absolute; bottom:-14px; width:98%;" class="d-block"> -->
        </div>
        <!---->
        <div class="p-3" style="margin-top: -10px;">
            <p>
                <b>{{ __('sentence.Patient Name') }} :</b> {{ $prescription->User->name }}
                @isset($prescription->User->Patient->birthday)
                    - <b>{{ __('sentence.Age') }} :</b> {{ $prescription->User->Patient->birthday }}
                    ({{ \Carbon\Carbon::parse($prescription->User->Patient->birthday)->age }} Years)
                @endisset
                <span>-<b>{{ __('sentence.Date') }}:</b> {{ Carbon\Carbon::today()->format('m-d-Y') }}</span>      
                
            </p>
            <!---->
            <div>
                @if (count($prescription_drugs) > 0)
                    @foreach ($prescription_drugs as $drug)
                        <li>{{ $drug->type }} - {{ $drug->Drug->trade_name }} {{ $drug->strength }} -
                            {{ $drug->dose }} - {{ $drug->duration }} <br> {{ $drug->drug_advice }}
                        </li>
                        @if ($loop->last)
                                        <div style="margin-bottom: 150px;"></div>
                                        <hr>
                        @endif
                    @endforeach
                @endif
            </div>
            <!---->
            <div>
                @if (count($prescription_certificate) > 0)
                    <strong><u>{{ __('sentence.Certificate') }} </u></strong>
                    @foreach ($prescription_certificate as $item)
                        <li>{{ $item->description }}</li>
                    @endforeach
                @endif
            </div>
            <!---->
            <div>
                @if (count($prescription_tests) > 0)
                    <strong><u>{{ __('sentence.Test to do') }} </u></strong><br><br>
                    @foreach ($prescription_tests as $test)
                        <li>{{ $test->Test->test_name }} @empty(!$test->description)
                                - {{ $test->description }}
                            @endempty
                        </li>
                        {{--@if ($loop->last)--}}
                            {{--<div style="margin-bottom: 150px;"></div>--}}
                            {{--<hr>--}}
                        {{--@endif--}}
                    @endforeach
                @endif
            </div>
           
        </div>
        <!---->
        <div class="d-flex align-items-center border_top_1px pt-2">
            <b style="color:#2450d3; font-size:18px;">{!! $setting->footer_left??'' !!}</b>
            <span class="ml-auto" style="color:#2450d3; font-size:14px;">{!! $setting->footer_right??'' !!}</span>
        </div>
    </div>
</div>
@endsection

@section('header')
    <style type="text/css">
        p,
        u,
        li {
            color: #444444 !important;
        }
    </style>
@endsection
@section('footer')
    <script src="{{ asset('js/pdf.js') }}"></script>
    <script>
        $( document ).ready(function() {
            // Choose the element that our invoice is rendered in.
            const element = document.getElementById('invoice');
            // Choose the element and save the PDF for our user.
            html2pdf()
                .set({
                    html2canvas: {
                        scale: 4
                    }
                })
                .from(element)
                .save();
            });
    </script>
@endsection
