@extends('layouts.master')

@section('title')
{{ __('sentence.Edit Patient') }}
@endsection

@section('content')


    <div class="row justify-content-center">                  

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">{{ __('sentence.Edit Patient') }}</h6>
                </div>
                <div class="card-body">
                 <form method="post" action="{{ route('patient.store_edit') }}">
                    <div class="form-group row">
                      <label for="Name" class="col-sm-3 col-form-label">{{ __('sentence.Full Name') }}<font color="red">*</font></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="Name" name="name" value="{{ $patient->name }}">
                        <input type="hidden" class="form-control" name="user_id" value="{{ $patient->id??'' }}">
                        {{ csrf_field() }}
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="Email" class="col-sm-3 col-form-label">{{ __('sentence.Patient Id') }}<font color="red">*</font></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="id" name="id" value="{{ $patient->Patient->patient_id??'' }}" required>
                      </div>
                  </div>
                    <div class="form-group row">
                      <label for="Birthday" class="col-sm-3 col-form-label">{{ __('sentence.Birthday') }}<font color="red">*</font></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="Birthday" name="birthday"  value="{{ $patient->Patient->birthday??'' }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="Phone" class="col-sm-3 col-form-label">{{ __('sentence.Phone') }}</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="Phone" name="phone" value="{{ $patient->Patient->phone }}">
                      </div>
                    </div>
                    <div class="form-group row">
                            <label for="Phone" class="col-sm-3 col-form-label">ARS</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="ars" name="ars" value="{{ $patient->Patient->ars ??'' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Phone" class="col-sm-3 col-form-label">Afiliado #</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="afiliado" name="afiliado" value="{{ $patient->Patient->afiliado ??'' }}">
                            </div>
                        </div>
                    <div class="form-group row">
                      <label for="Gender" class="col-sm-3 col-form-label">{{ __('sentence.Gender') }}<font color="red">*</font></label>
                      <div class="col-sm-9">
                        <select class="form-control" name="gender" id="Gender">
                          <option value="{{ $patient->Patient->gender }}" selected="selected">{{ $patient->Patient->gender }}</option>
                          <option value="Male">{{ __('sentence.Male') }}</option>
                          <option value="Female">{{ __('sentence.Female') }}</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="Blood" class="col-sm-3 col-form-label">{{ __('sentence.Blood Group') }}</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="blood" id="Blood">
                                            <option value="{{ $patient->Patient->blood }}" selected="selected">{{ $patient->Patient->blood }}</option>
                                            <option value="Unknown">{{ __('sentence.Unknown') }}</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="clinic" class="col-sm-3 col-form-label">Clinic</label>
                      <div class="col-sm-9">
                          <select class="form-control" name="clinic" id="clinic">
                              @foreach ($clinic as $item)
                                  <option value="{{ $item->id ?? '' }}" @if($patient->clinic_id==$item->id) selected @endif>{{ $item->name ?? '' }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                    <div class="form-group row">
                      <label for="Address" class="col-sm-3 col-form-label">{{ __('sentence.Address') }}</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="Address" name="adress" value="{{ $patient->Patient->adress }}">
                      </div>
                    </div>

                   
                    <div class="form-group row">
                      <label for="Weight" class="col-sm-3 col-form-label">{{ __('sentence.Patient Weight') }}</label>
                      <div class="col-sm-9">
                        <div class="input-group mb-2">
                          <input type="text" class="form-control" id="Weight" name="weight" value="{{ $patient->Patient->weight }}">
                          <div class="input-group-prepend">
                            <div class="input-group-text">LB</div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="height" class="col-sm-3 col-form-label">{{ __('sentence.Patient Height') }}</label>
                      <div class="col-sm-9">
                        <div class="input-group mb-2">
                          <input type="text" class="form-control" id="height" name="height" value="{{ $patient->Patient->height }}">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Ft</div>
                          </div>
                        </div>
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
