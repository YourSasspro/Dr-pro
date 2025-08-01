@extends('layouts.master')

@section('title')
{{ __('sentence.Clinic') }}
@endsection

@section('content')


    <div class="row justify-content-center">                  

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">{{ __('sentence.Update') }} {{ __('sentence.Clinic') }} </h6>
                </div>
                <div class="card-body">
                 <form method="post" action="{{ route('clinic.update',$clinic->id) }}" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                    <div class="form-group row">
                      <label for="Name" class="col-sm-3 col-form-label">{{ __('sentence.Full Name') }}<font color="red">*</font></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="Name" name="name" value="{{ $clinic->name??'' }}" required>
                      </div>
                    </div>
                    @if(isset($doctor))
                        <div class="form-group row">
                            <label for="Name" class="col-sm-3 col-form-label">Doctor/Dentist<font color="red">*</font></label>
                            <div class="col-sm-9">
                                <select name="doctor" class="form-control" id="">
                                    @foreach ($doctor as $item)
                                    <option value="{{$item->id}}" {{($clinic->doctor_id==$item->id)?'selected':''}}>{{$item->name??''}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                    <div class="form-group row">
                      <label for="address" class="col-sm-3 col-form-label"> {{ __('sentence.Address') }}<font color="red">*</font></label>
                      <div class="col-sm-9">
                        <input type="address" class="form-control" id="address" name="address" value="{{ $clinic->address??'' }}" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="address" class="col-sm-3 col-form-label">Old Logo</label>
                      <div class="col-sm-9">
                          <img src="{{asset($clinic->logo)}}" style="height: 100px; width:100px;" alt="">
                      </div>
                  </div>
                    <div class="form-group row">
                      <label for="address" class="col-sm-3 col-form-label">New Logo</label>
                      <div class="col-sm-9">
                          <input type="file" class="form-control" id="logo" name="logo">
                      </div>
                  </div>
                    <div class="form-group row">
                      <label for="address" class="col-sm-3 col-form-label">{{ __('sentence.Tel') }}<font color="red">*</font></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="tel" name="tel"  value="{{ $clinic->tel??'' }}" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="address" class="col-sm-3 col-form-label">{{ __('sentence.Cel') }}<font color="red">*</font></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="cel" name="cel"  value="{{ $clinic->cel??'' }}" required>
                      </div>
                  </div>
                    
                    <div class="form-group row">
                      <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary"> {{ __('sentence.Update') }}</button>
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
