<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function index()
    {
        return User::visibleTo(Auth::user())->get();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        return User::create($request->all());
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
