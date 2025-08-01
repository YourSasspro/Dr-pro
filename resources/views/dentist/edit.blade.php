@extends('layouts.master')

@section('title')
Dentist
@endsection

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Update Dentist
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("dentist.update", [$dentist->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $dentist->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                
            </div>
            <div class="form-group">
                <label class="required" for="email">Email</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $dentist->email) }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label class="required" for="degree1">Doctor Specialty</label>
                <input class="form-control" type="text" name="degree1" id="degree1" value="{{ old('degree1', $dentist->degree1) }}">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label class="required" for="degree2">Doctor Specialty</label>
                <input class="form-control" type="text" name="degree2" id="degree2" value="{{ old('degree2', $dentist->degree2) }}">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label class="required" for="password">Password</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>



@endsection