@extends('layouts.master')

@section('title')
{{ __('sentence.Clinic') }}
@endsection

@section('content')
    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('sentence.New Clinic') }}</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('clinic.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="Name" class="col-sm-3 col-form-label">{{ __('sentence.Full Name') }}<font color="red">*</font></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Name" name="name" required>
                            </div>
                        </div>
                        @if(isset($doctor))
                        <div class="form-group row">
                            <label for="Name" class="col-sm-3 col-form-label">Doctor/Dentist<font color="red">*</font></label>
                            <div class="col-sm-9">
                                <select name="doctor" class="form-control" id="">
                                    @foreach ($doctor as $item)
                                    <option value="{{$item->id}}">{{$item->name??''}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">{{ __('sentence.Address') }}<font color="red">*</font></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">Logo<font color="red">*</font></label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="logo" name="logo" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">{{ __('sentence.Tel') }}<font color="red">*</font></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tel" name="tel" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">{{ __('sentence.Cel') }}<font color="red">*</font></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="cel" name="cel" required>
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
