<!-- resources/views/rooms/search.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room検索') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- 検索フォーム -->
                    <form action="{{ route('rooms.search') }}" method="GET" class="mb-6">
                        <div class="flex items-center">
                            <input type="text" name="keyword"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
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

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($rooms as $room)
                                <div class="flex flex-col justify-between bg-white p-10 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                                    
                                    <!-- Room Header with Icon and Title -->
                                    <div class="flex flex-col items-start mb-4">
                                        <h3 class="text-2xl font-bold text-gray-800 text-center">{{ $room->title ?? 'なし' }}</h3>

                                        <div class="flex items-center mt-4">
                                            
                                            <!-- Icon Placeholder (You can replace this with an actual icon if needed) -->
                                            <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center mr-4 mt-2">
                                                <svg class="absolute w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            
                                            <!-- User Name -->
                                            <div class="flex-1">
                                                <a href="{{ route('profile.show', $room->user) }}" class="block mt-1 text-gray-500 text-xl">{{ $room->user->name }}</a>
                                            </div>
                                        </div>
                                        <p class="self-end text-gray-500 text-sm ml-2">{{ $room->created_at->diffForHumans() }}</p>
                                    </div>

                                    <!-- Room Content and Details -->
                                    <div class="flex flex-col justify-end">
                                        <div id="restored-content-{{ $room->id }}" class="mt-4 text-gray-600 max-h-[128px] overflow-auto"></div>

                                        <div class="text-gray-500 text-lg mt-2">
                                            <p>参加中: {{ count($room->room_members) }} / {{ $room->size }}</p>
                                            <p>カテゴリー: {{ $room->category->category_name ?? 'なし' }}</p>
                                        </div>

                                        <!-- Room Details Button -->
                                        <form method="GET" action="{{ route('rooms.show', $room) }}" class="w-full flex justify-end">
                                            @csrf
                                            <button type="submit"
                                                class="
                                                flex self-end px-6 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-500 transition-all duration-300">
                                                詳細
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Quill editor content setup -->
                                <script>
                                    var contentText = '{!! $room->data_json !!}';
                                    var json = contentText.replace(/\n/g, '\\n');
                                    json = JSON.parse(json);
                                    const restoredContent{{ $room->id }} = new Quill('#restored-content-{{ $room->id }}');
                                    restoredContent{{ $room->id }}.setContents(json);
                                    restoredContent{{ $room->id }}.disable();
                                </script>
                            @endforeach
                        </div>

                        <!-- ページネーション -->
                        <div class="mt-4">
                            {{ $rooms->appends(request()->input())->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No rooms found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
