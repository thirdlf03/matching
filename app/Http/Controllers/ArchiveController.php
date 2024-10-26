<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;

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
        return response()->noContent();
    }
}

