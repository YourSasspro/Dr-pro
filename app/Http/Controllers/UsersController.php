<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('role','!=','patient')->where('role','!=','sectary')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all()->pluck('title', 'id');

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
