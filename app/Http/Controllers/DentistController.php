<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class DentistController extends Controller
{
    public function index()
    {
        $dentist = User::where('role','=','dentist')->get();
        return view('dentist.index', compact('dentist'));
    }

    public function create()
    {
        return view('dentist.create');
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return redirect()->route('dentist.index');
    }

    public function edit(User $dentist)
    {
        return view('dentist.edit', compact('dentist'));
    }

    public function update(Request $request, User $dentist)
    {
        $dentist->update($request->all());

        return redirect()->route('dentist.index');
    }

    public function show(User $dentist)
    {
        return view('dentist.show', compact('dentist'));
    }

    public function destroy(User $dentist)
    {
        $dentist->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
