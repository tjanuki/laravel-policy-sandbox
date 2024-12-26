<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController
{
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        return User::visibleTo(Auth::user())->get();
    }

    public function show(User $user)
    {
        Gate::authorize('view', $user);

        return $user;
    }

    public function store(Request $request)
    {
        Gate::authorize('create', User::class);

        return User::create($request->all());
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        $user->update($request->all());
        return $user;
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();
        return response()->json(null, 204);
    }
}
