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
        $user_id = auth() ->id();
        //dd($request);
        // デフォルトのステータス値を設定
    $status = $request->input('status', '未着手'); // デフォルトは「未着手」
        //ロールを作成
        RoomRole::create([
            'user_id' => $user_id,
            'room_id' => $request -> room_id,
            'role_name' => $request -> role_name,
            'status' => $request -> status,
        ]);

        

        //ルームページにリダイレクトすると同時にロールページを表示
        return redirect()->route('rooms.show',['room' => $request->room_id]);
    }

    
    public function destroy(Request $request, Room $room)
    {
        //ロールの削除処理
        $room_role->delete();

        return redirect()->route('rooms.show',['room' => $room_id]);
    }
}
