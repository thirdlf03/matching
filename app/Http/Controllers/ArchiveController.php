<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Room;
use App\Models\User;

class ArchiveController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Archive $archive)
    {
        if ($archive->user_id !== auth()->id()) {
            abort(403, '権限がありません');
        }
        $archive->delete();

        $user = User::find($archive->user_id);

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
}
