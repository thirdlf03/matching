<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomRole;
use Illuminate\Http\Request;

class RoomRoleController extends Controller
{
    public function store(Request $request, Room $room)
    {
        //ロールが記入されているか確認
        $request->validate([
            'role_name' => 'required',
            'room_id' => 'required|exists:rooms,id', // room_id が存在するかどうかもチェック
        ]);

        //$taskData = json_decode($request->input('role'),true);

        //ロールの作成と保存
        //dd($request);
        // デフォルトのステータス値を設定
        $status = $request->input('status', '未着手'); // デフォルトは「未着手」
        //ロールを作成
        RoomRole::create([
            'user_id' => $request->assigned_member,
            'room_id' => $request->room_id,
            'role_name' => $request->role_name,
            'status' => $request->status,
        ]);

        //ルームページにリダイレクトすると同時にロールページを表示
        return redirect()->route('rooms.show', ['room' => $request->room_id]);
    }

    public function update(Request $request, $role_id)
    {
        //ロールの更新処理
        $room_role = RoomRole::find($role_id);
        $room_role->update([
            'user_id' => $request->user_id,
            'role_name' => $request->role_name,
            'status' => $request->status,
        ]);

        $roomd = $request->room_id;

        return redirect()->route('rooms.show', ['room' => $roomd]);

    }

    public function destroy(Request $request, $role_id)
    {
        $room_role = RoomRole::find($role_id);

        // Delete the RoomRole instance
        $room_role->delete();

        $roomd = $request->room_id;

        // Redirect to the room's show page
        return redirect()->route('rooms.show', ['room' => $roomd]);
    }
}
