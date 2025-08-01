@extends('layouts.master')

@section('title')
Users
@endsection

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Create User
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="first_name">Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="email">Email</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label class="required" for="degree1">Doctor Specialty</label>
                <input class="form-control" type="text" name="degree1" id="degree1" value="{{ old('degree1') }}">
                <span class="help-block"></span>
            </div>
            {{-- <div class="form-group">
                <label class="required" for="degree2">Doctor Specialty</label>
                <input class="form-control" type="text" name="degree2" id="degree2" value="{{ old('degree2') }}">
                <span class="help-block"></span>
            </div> --}}
            <div class="form-group">
                <label class="required" for="password">Password</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label class="required" for="roles">Role</label>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="role" id="role" required>
                        <option value="doctor">Doctor</option>
                        <option value="dentist">Dentist</option>
                        <option value="admin">Admin</option> 
                </select>
                @if($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>



@endsection