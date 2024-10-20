<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Chat;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ルームのデータをビューに渡して新しい順に一覧表示させる。
        $rooms = Room::with(['user', 'room_members'])->latest()->get();

        return view('rooms.index', compact('rooms'));
        //dd($rooms);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //ルーム作成ページを表示する
        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //ルームの新規保存を処理。ユーザーが送信したデータをDBに保存し、一覧ページにリダイレクト
        $request->validate([
            'size' => 'required',
            'title' => 'required',
            'data_json' => 'required',
        ]);

        //ルームの作成と保存
        $user_id = auth()->id();

        Room::create([
            'data_json' => $request->data_json,
            'title' => $request->title,
            'user_id' => $user_id,
            'size' => $request->size,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        //ルーム一覧ページにリダイレクト
        return redirect()->route('rooms.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $chats = Chat::find($room->id)->get();
        return view('rooms.show', compact(['room', 'chats']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //ルームの編集画面を表示する
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'size' => 'required',
            'title' => 'required',
            'data_json' => 'required',
        ]);

        $room->update([
            'data_json' => $request->data_json,
            'title' => $request->title,
            'size' => $request->size,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //ルームの削除処理
        $room->delete();

        return redirect()->route('rooms.index');
    }
}
