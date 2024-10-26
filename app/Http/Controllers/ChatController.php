<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
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

        $chat = Chat::create([
            'user_id' => $user_id,
            'room_id' => $request->room_id,
            'chat' => $request->chat,
        ]);

        MyEvent::dispatch(
            ['user_id' => $user_id,
                'user' => ['name' => auth()->user()->name],
                'avatar' => auth()->user()->image_url,
                'chat' => $request->chat,
                'created_at' => $chat->created_at,
                'room_id' => $request->room_id, ]
        );

        //チャットの送信をブロードキャスト
        return response()->noContent();

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
