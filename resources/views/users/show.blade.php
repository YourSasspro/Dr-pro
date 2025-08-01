@extends('layouts.master')

@section('title')
Users
@endsection

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        View User
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('users.index') }}">
                    Back to List
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $user->id??'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            {{ $user->name??'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Email
                        </th>
                        <td>
                            {{ $user->email??'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Doctor Specialty
                        </th>
                        <td>
                            {{ $user->degree1??'' }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            Doctor Specialty
                        </th>
                        <td>
                            {{ $user->degree2??'' }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            Email Verify
                        </th>
                        <td>
                            {{ $user->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Role
                        </th>
                        <td>
                                <span class="label label-info">{{ $user->role??'' }}</span>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('users.index') }}">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>



@endsection