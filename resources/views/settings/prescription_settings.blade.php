@extends('layouts.master')

@section('title')
{{ __('sentence.Prescription Settings') }}
@endsection

@section('content')

<div class="row justify-content-center">
   <div class="col-md-8">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('sentence.Prescription Settings') }}</h6>
         </div>
         <div class="card-body">
            <form method="post" action="{{ route('prescription_settings.store') }}" enctype="multipart/form-data">
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputEmail4">Logo</label>
                     <img src="{{asset($setting->logo??'') }}" style="height: 100px;" alt="">
                     <input type="file" name="logo" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputPassword4">Doctor Name</label>
                     <input type="text" class="form-control" id="inputPassword4" name="name" value="{{ $setting->name??'' }}" required>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputEmail4">Doctor Degree</label>
                     <input type="text" name="degree" value="{{ $setting->degree??'' }}" class="form-control" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputPassword4">Address</label>
                     <input type="text" class="form-control" id="inputPassword4" name="address" value="{{ $setting->address??'' }}" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputPassword4">Tel</label>
                     <input type="text" class="form-control" id="inputPassword4" name="tel" value="{{ $setting->tel??'' }}" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputPassword4">Cel</label>
                     <input type="text" class="form-control" id="inputPassword4" name="cel" value="{{ $setting->cel??'' }}" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputEmail4">Footer (Left)</label>
                     <textarea class="form-control" id="inputPassword4" name="footer_left" required>{{ $setting->footer_left??'' }}</textarea>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputPassword4">Footer (Right)</label>
                     <textarea class="form-control" id="inputPassword4" name="footer_right" required>{{ $setting->footer_right??'' }}</textarea>
                     {{ csrf_field() }}
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary">{{ __('sentence.Save') }}</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

@section('header')

@endsection

@section('footer')

@endsection