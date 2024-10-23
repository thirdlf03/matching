<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Chat;
use App\Models\Archive;
use App\Models\Category;

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
        $categories = Category::all();

        $selected_category_id = null;
        //ルーム作成ページを表示する
        return view('rooms.create', compact(['categories', 'selected_category_id']));
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

        $room = Room::create([
            'data_json' => $request->data_json,
            'title' => $request->title,
            'user_id' => $user_id,
            'size' => $request->size,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'category_id' => $request->category_id,
            'is_show' => $request->is_show,
        ]);

        //ルーム一覧ページにリダイレクト
        return redirect()->route('rooms.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $chats = Chat::where('room_id', $room->id)->get();
        return view('rooms.show', compact(['room', 'chats']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //ルームの編集画面を表示する
        $categories = Category::all();
        $selected_category_id = $room->category_id;

        return view('rooms.edit', compact(['room', 'categories', 'selected_category_id']));
    }


    public function search(Request $request)
    {
        $query = Room::query();

        // 検索キーワードが指定されている場合の処理
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            // titleで部分一致検索
            $query->where('title', 'like', '%' . $keyword . '%');
        }

        // sizeが指定されている場合のフィルタリング
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        // ページネーション（1ページに10件表示）
        $rooms = $query->latest()->paginate(10);

        // 検索結果をビューに渡す
        return view('rooms.search', compact('rooms'));
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
            'category_id' => $request->category_id,
            'is_show' => $request->is_show,
        ]);

        return redirect()->route('rooms.show', $room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $user_id = auth()->id();

        Archive::create([
            'data_json' => $room->data_json,
            'title' => $room->title,
            'user_id' => $user_id,
            'size' => $room->size,
            'latitude' => $room->latitude,
            'longitude' => $room->longitude,
            'category_id' => $room->category_id,
        ]);

        //ルームの削除処理
        $room->delete();

        return redirect()->route('rooms.index');
    }
}
