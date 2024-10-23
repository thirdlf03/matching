<?php

namespace App\Http\Controllers;

use App\Models\RoomRole; // RoomRoleモデルをインポート
use Illuminate\Http\Request;

class RoomRoleController extends Controller
{
    public function store(Request $request)
    {
        // ロール名が入力されているか確認
        $request->validate([
            'role_name' => 'required',
        ]);

        // ロールの作成と保存
        $user_id = auth()->id();

        // RoomRoleを作成
        RoomRole::create([
            'user_id' => $user_id,
            'room_id' => $request->room_id,
            'role_name' => $request->role_name,
        ]);

        // ルームページにリダイレクトし、ロールページが開いている状態にする
        //return redirect()->route('rooms.show', $request->room_id)->with('openRole', true);
    }

    public function destroy(RoomRole $room_role)
    {
        // ロールの削除処理
        $room_role->delete();

        // ルームページにリダイレクトし、ロールページが開いている状態にする
        //return redirect()->route('rooms.show', $room_role->room_id)->with('openRole', true);
    }
}
