@extends('layouts.master')

@section('title')
Permissions
@endsection

@section('content')


<div class="card shadow mb-4">
    <div class="card-header py-3">
        View Permission
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('permissions.index') }}">
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
                            {{ $permission->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Title
                        </th>
                        <td>
                            {{ $permission->title }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('permissions.index') }}">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>



@endsection