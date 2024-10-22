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
        $archive->delete();

        return response()->noContent();
    }
}
