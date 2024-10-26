<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user)
    {
        auth()->user()->follows()->attach($user->id);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        auth()->user()->follows()->detach($user->id);

        return back();
    }
}
