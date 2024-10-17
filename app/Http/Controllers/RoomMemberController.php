<?php

namespace App\Http\Controllers;

use App\Models\RoomMember;
use Illuminate\Http\Request;

class RoomMemberController extends Controller
{
    
    //ルームメンバーの一覧表示

    public function index()
    {
        // RoomMemberの全項目を取得
        $roomMembers = RoomMember::all();

        // room_members.index ビューにデータを渡して表示
        return view('room_members.index', ['roomMembers' => $roomMembers]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomMember $roomMember)
    {
        //
    }
}
