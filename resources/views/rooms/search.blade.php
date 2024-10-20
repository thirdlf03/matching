@extends('layouts.app')

@section('content')
<h1>Room検索結果</h1>

<form action="{{ route('rooms.search') }}" method="GET">
    <input type="text" name="keyword" placeholder="Room名で検索" value="{{ request('keyword') }}">
    <input type="number" name="size" placeholder="サイズで検索" value="{{ request('size') }}">
    <button type="submit">検索</button>
</form>

@if ($rooms->isEmpty())
    <p>該当するRoomがありません。</p>
@else
    <ul>
        @foreach ($rooms as $room)
            <li>
                <strong>Title:</strong> {{ $room->title }}<br>
                <strong>Size:</strong> {{ $room->size }}<br>
                <strong>Latitude:</strong> {{ $room->latitude }}<br>
                <strong>Longitude:</strong> {{ $room->longitude }}<br>
            </li>
        @endforeach
    </ul>

    {{ $rooms->links() }} <!-- ページネーションのリンク -->
@endif
@endsection

