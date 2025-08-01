@extends('layouts.master')

@section('title')
    {{ __('sentence.Sectary') }}
@endsection

@section('content')


    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('sentence.Update Sectary') }}</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('sectary.update', $sectary->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="Name" class="col-sm-3 col-form-label">{{ __('sentence.Full Name') }}<font
                                    color="red">*</font></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Name" name="name"
                                    value="{{ $sectary->name }}">
                            </div>
                        </div>
                        @if (isset($doctor))
                            <div class="form-group row">
                                <label for="Name" class="col-sm-3 col-form-label">Doctor/Dentist<font color="red">*
                                    </font></label>
                                <div class="col-sm-9">
                                    <select name="doctor" class="form-control" id="">
                                        @foreach ($doctor as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $sectary->doctor_id == $item->id ? 'selected' : '' }}>{{ $item->name ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="Email" class="col-sm-3 col-form-label">{{ __('sentence.Email') }}<font
                                    color="red">*</font></label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="Email" name="email"
                                    value="{{ $sectary->email }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">{{ __('sentence.Update Sectary') }}</button>
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
