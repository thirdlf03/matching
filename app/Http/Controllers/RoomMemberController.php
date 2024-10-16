<?php

namespace App\Http\Controllers;

use App\Models\RoomMember;
use Illuminate\Http\Request;

class RoomMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomMember $roomMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomMember $roomMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomMember $roomMember)
    {
        //ルームの更新処理を実装
        $request->validate([
            'room' => 'required',
        ]);

        $rooms->update($request->only('room'));
        return redirect()->route('room.show',$room);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomMember $roomMember)
    {
        //
    }
}
