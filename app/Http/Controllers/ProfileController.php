<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Archive;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show(User $user)
    {
        if (auth()->user()->is($user)) {
            $rooms = Room::query()
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            $rooms = $user
                ->rooms()
                ->latest()
                ->paginate(10);
        }

        $archives = Archive::query()
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $user->load(['follows', 'followers']);

        return view('profile.show', compact('user', 'rooms', 'archives'));
    }

    public function showFollowers(User $user)
    {
        // 指定されたユーザーのフォロワーを取得
        $followers = $user->followers()->get();  // フォロワーのリストを取得

        // ビューにユーザーとフォロワー一覧を渡す
        return view('profile.follower', compact('user', 'followers'));
    }

    public function showFollowing(User $user)
    {
        // 指定されたユーザーのフォロワーを取得
        $following = $user->follows()->get();  // フォロワーのリストを取得

        // ビューにユーザーとフォロワー一覧を渡す
        return view('profile.following', compact('user', 'following'));
    }
}
