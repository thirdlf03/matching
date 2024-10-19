<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomMemberController extends Controller
{

    //ルームメンバーの一覧表示

    public function index()
    {
        // roommember.index ビューにデータを渡して表示
        return view('roommember.index', [
            'roomMembers' => $roomMembers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function store(Request $request)
    {
        // バリデーションでデータの型があっているか確認
         $validatedData = $request->validate([
            'room_id' =>'required',
        ]);

        $user_id = auth()->id();
        $room_id = $request->input('room_id');

        $room = Room::find($room_id);
        $room->room_members()->attach($user_id);

        // 成功後、一覧画面にリダイレクトしてフラッシュメッセージを表示
        return redirect()->route('rooms.show', $room)->with('status', 'ルームメンバー作成');
    }


    public function destroy(Request $request, Room $room)
    {
        // バリデーションでデータの型があっているか確認
         $validatedData = $request->validate([
            'room_id' =>'required',
        ]);

        $user_id = auth()->id();
        $room_id = $request->input('room_id');

        $room = Room::find($room_id);
        $room->room_members()->detach($user_id);

        // 成功メッセージ付きで一覧ページにリダイレクト
        return redirect()->route('rooms.show', $room);
    }
}
