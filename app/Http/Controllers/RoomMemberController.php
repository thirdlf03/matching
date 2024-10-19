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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:room_members,email',
        ]);

        // 新しいRoomMemberの保存
        $roomMember = new RoomMember();
        $roomMember->name = $validatedData['name'];
        $roomMember->email = $validatedData['email'];
        $roomMember->save();

        // 成功後、一覧画面にリダイレクトしてフラッシュメッセージを表示
        return redirect()->route('roommember.index')->with('status', 'ルームメンバー作成');
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
    public function destroy($id)
    {
        // 指定されたIDのRoomMemberを取得
        $roomMember = RoomMember::findOrFail($id);

        // データを削除
        $roomMember->delete();

        // 成功メッセージ付きで一覧ページにリダイレクト
        return redirect()->route('roommember.index')->with('status', 'ルームメンバー削除');
    }
}
