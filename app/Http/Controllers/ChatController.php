<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //チャットのデータをビューに渡して一覧表示させる。
        //$chats = Chat::with(['user', 'room'])->get();

        //return view('chats.index', compact('chats'));
        //dd($chats);
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
        //チャットの新規保存を処理。ユーザーが送信したデータをDBに保存し
        $request->validate([
            'chat' => 'required',
        ]);

        //chatの作成と保存
        $user_id = auth()->id();

        Chat::create([
            'user_id' => $user_id,
            'room_id' => $request -> room_id,
            'chat' => $request -> chat,
        ]);

    return redirect()->route('rooms.show', ['room' => $request->room_id])
                    ->with('openChat', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //チャットの削除処理
        $chat->delete();

        return redirect()->with('message'); //route('rooms.index');
    }
}
