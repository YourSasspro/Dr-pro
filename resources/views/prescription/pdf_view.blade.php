@php
    $setting = Setting();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="zXbiSv6MysbCo84DXZ4JSrdGP6dkFJbqvwo0wgSS">
    <title>Doctorino - {{ __('sentence.View Prescription') }}
    </title>
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 

</head>

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

<body id="page-top">
    <div id="app">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col">
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
                                        <div class="row">
                                            <div class="col">
                                                <p>
                                                    <b>{{ __('sentence.Patient Name') }} :</b>
                                                    {{ $prescription->User->name }}
                                                    @isset($prescription->User->Patient->birthday)
                                                        - <b>{{ __('sentence.Age') }} :</b>
                                                        {{ $prescription->User->Patient->birthday }}
                                                        ({{ \Carbon\Carbon::parse($prescription->User->Patient->birthday)->age }}
                                                        {{ __('sentence.Years') }})
                                                    @endisset
                                                    @isset($prescription->User->Patient->gender)
                                                        - <b>{{ __('sentence.Gender') }} :</b>
                                                        {{ __('sentence.' . $prescription->User->Patient->gender) }}
                                                    @endisset
                                                    @isset($prescription->User->Patient->weight)
                                                        - <b>{{ __('sentence.Patient Weight') }} :</b>
                                                        {{ $prescription->User->Patient->weight }} Kg
                                                    @endisset
                                                    @isset($prescription->User->Patient->height)
                                                        - <b>{{ __('sentence.Patient Height') }} :</b>
                                                        {{ $prescription->User->Patient->height }}
                                                    @endisset
                                                </p>
                                                <hr>
                                                <h5 class="text-center"><b>{{ __('sentence.Prescription') }}</b></h5>
                                                <hr>
                                            </div>
                                        </div>
                                        <!-- END ROW : Patient informations -->
                                        <!-- ROW : Drugs List -->
                                        <div class="row justify-content-center">
                                            <div class="col">
                                                @forelse ($prescription_drugs as $drug)
                                                    <li>{{ $drug->type }} - {{ $drug->Drug->trade_name }}
                                                        {{ $drug->strength }} - {{ $drug->dose }} -
                                                        {{ $drug->duration }} <br> {{ $drug->drug_advice }}</li>
                                                @empty
                                                    <p>{{ __('sentence.No Drugs') }}</p>
                                                @endforelse
                                            </div>
                                        </div>
                                        <!-- END ROW : Drugs List -->
                                        @if (count($prescription_certificate) > 0)
                                            <!-- ROW : Tests List -->
                                            <div class="row justify-content-center">
                                                <div class="col">
                                                    <strong><u>Certificate </u></strong><br><br>
                                                    @foreach ($prescription_certificate as $item)
                                                        <li>{{ $item->description }}</li>
                                                        @if ($loop->last)
                                                            <div style="margin-bottom: 150px;"></div>
                                                            <hr>
                                                        @endif
                                                    @endforeach
                                                    <hr>
                                                </div>
                                            </div>
                                            <!-- END ROW : Tests List -->
                                        @endif
                                        <!-- ROW : Footer informations -->
                                        <footer>
                                            <hr>
                                            <div class="row" style="border-top:3px solid #2450d3;">
                                                <div class="col-md-6">
                                                    <b
                                                        style="color:#2450d3; font-size:18px;">{!! $setting->footer_left??'' !!}</b>
                                                </div>
                                                <div class="col-md-6" style="text-align: center;">
                                                    <span class="float-right"
                                                        style="color:#2450d3; font-size:14px;">{!! $setting->footer_right??'' !!}</span>
                                                </div>
                                            </div>
                                            <!-- END ROW : Footer informations -->
                                        </footer>
                                    </div>
                                </div>
                                <!---->
                                {{-- <div class="col-md-3">
                                    <p>Alger, {{ __('sentence.On') }} {{ $prescription->created_at->format('d-m-Y') }}</p>
                                </div> --}}
                                <hr style="border-top: 2px solid #2450d3; margin-top: 2px; position:absolute; bottom:-14px; width:98%;" class="d-block">
                            </div>
                            <!---->
                            <div class="p-3">
                                <p>
                                    <b>{{ __('sentence.Patient Name') }} :</b> {{ $prescription->User->name }}
                                    @isset($prescription->User->Patient->birthday)
                                        - <b>{{ __('sentence.Age') }} :</b> {{ $prescription->User->Patient->birthday }}
                                        ({{ \Carbon\Carbon::parse($prescription->User->Patient->birthday)->age }} Años)
                                    @endisset
                                    <span>-<b>{{ __('sentence.Date') }}:</b> {{Carbon\Carbon::today()->format('m-d-Y')}}</span>      
                                    {{-- @isset($prescription->User->Patient->weight)
                                        - <b>{{ __('sentence.Patient Weight') }} :</b>
                                        {{ $prescription->User->Patient->weight }} Kg
                                    @endisset
                                    @isset($prescription->User->Patient->height)
                                        - <b>{{ __('sentence.Patient Height') }} :</b>
                                        {{ $prescription->User->Patient->height }}
                                    @endisset --}}
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
                                                
                                            @endif
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
                                            @if ($loop->last)
                                                <div style="margin-bottom: 150px;"></div>
                                                <hr>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <!---->
                            </div>
                            <!---->
                            <div class="d-flex align-items-center border_top_1px pt-2">
                                <b style="color:#2450d3; font-size:18px;">{!! clean(App\Setting::get_option('footer_left')) !!}</b>
                                <span class="ml-auto" style="color:#2450d3; font-size:14px;">{!! clean(App\Setting::get_option('footer_right')) !!}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
    </div>
</body>

</html>
