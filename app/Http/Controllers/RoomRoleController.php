<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;


class RoomRoleController extends Controller
{


 
    public function store(Request $request)
    {
        //ロールが記入されているか確認
        $request->validate([
            'role_name' => 'required',
            
        ]);

        //ロールの作成と保存
        $user_id = auth() ->id();
        dd($request);
        //ロールを作成
        Role::create([
            'user_id' => $user_id,
            'room_id' => $request -> room_id,
            'role_name' => $request -> role_name,
            'status' => $request -> status,
        ]);

        //ルームページにリダイレクトすると同時にロールページを表示
        //return redirect()->with('role_page');
    }

    
    public function destroy(Request $request, Room $room)
    {
        //ロールの削除処理
        $room_role->delete();

        return redirect()->with('role_page');
    }
}
