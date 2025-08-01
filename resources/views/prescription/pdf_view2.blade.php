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
                                       <hr>
                                       <p>
                                          
                                       </p>
                                       <hr>
                                       <h5 class="text-center"><b></b></h5>
                                       <hr>
                                    </div>
                                 </div>
                                 <!-- END ROW : Patient informations -->
                                 <!-- ROW : Drugs List -->
                                 <div class="row justify-content-center">
                                    <div class="col">
                                     
                                    </div>
                                 </div>
                                 <!-- END ROW : Drugs List -->
                                 <!-- ROW : Footer informations -->
                                 <footer>
                                    <hr>
                                    <div class="row" style="border-top:3px solid #2450d3;">
                                       <div class="col-md-6">
                                          <b style="color:#2450d3; font-size:18px;">{!! $setting->footer_left??'' !!}</b>
                                       </div>
                                       <div class="col-md-6" style="text-align: center;">
                                          <span class="float-right" style="color:#2450d3; font-size:14px;">{!! $setting->footer_right??'' !!}</span>
                                       </div>
                                    </div>
                                    <!-- END ROW : Footer informations -->
                                 </footer>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Page Heading -->
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