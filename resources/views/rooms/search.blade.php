<!-- resources/views/rooms/search.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Room検索') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- 検索フォーム -->
                    <form action="{{ route('rooms.search') }}" method="GET" class="mb-6">
                        <div class="flex items-center">
                            <input type="text" name="keyword"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Search for rooms..." value="{{ request('keyword') }}">
                            <button type="submit"
                                class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                                Search
                            </button>
                        </div>
                    </form>

                    <!-- 検索結果表示 -->
                    @if ($rooms->count())

                        <!-- ページネーション -->
                        <div class="mb-4">
                            {{ $rooms->appends(request()->input())->links() }}
                        </div>

                        @foreach ($rooms as $room)
                            <div class="flex items-center">
                                <p class="font-bold text-sm lg:text-lg mt-4">募集人数: {{ $room->size }}</p>
                                <p class="font-bold mx-7 text-sm lg:text-lg mt-4">参加中:
                                    {{ count($room->room_members) }}</p>
                                <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">部屋名:
                                    {{ $room->title }}</p>
                            </div>
                            <div class="mt-2 mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <div id="restored-content-{{ $room->id }}"></div>
                                <a href="{{ route('profile.show', $room->user) }}">
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $room->user->name }}</p>
                                </a>
                                <form method="GET" action="{{ route('rooms.show', $room) }}">
                                    @csrf
                                    <div class="flex justify-end mt-4">
                                        <div
                                            class="bg-blue-500 hover:bg-blue-700 text-gray-200 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            <button type="submit">
                                                詳細
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <script>
                                var content_text = '{!! $room->data_json !!}';
                                var json = content_text.replace(/\n/g, '\\n');
                                json = JSON.parse(json);
                                const restoredContent{{ $room->id }} = new Quill('#restored-content-{{ $room->id }}');
                                restoredContent{{ $room->id }}.setContents(json);
                                console.log(json);
                                restoredContent{{ $room->id }}.disable();
                            </script>
                        @endforeach

                        <!-- ページネーション -->
                        <div class="mt-4">
                            {{ $rooms->appends(request()->input())->links() }}
                        </div>
                    @else
                        <p>No rooms found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
