<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Room詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center">
                            <p class="font-bold text-sm lg:text-lg mt-4">募集人数: {{ $room->size }}</p>
                            <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">部屋名:
                                {{ $room->title }}</p>
                        </div>

                        @if ($room->user_id == auth()->id())
                            <form method="POST" action="{{ route('rooms.destroy', $room) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    削除
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="mt-2 mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <div id="restored-content-{{ $room->id }}"></div>
                        <p class="my-2">場所</p>
                        <iframe
                            src="https://maps.google.com/maps?output=embed&q={{ $room->latitude }},{{ $room->longitude }}&ll={{ $room->latitude }},{{ $room->longitude }}&t=m&hl=ja&z=18"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $room->user->name }}</p>
                        @if ($room->user_id != auth()->id())
                            <form method="POST" action="{{ route('roomMembers.store') }}">
                                @csrf
                                <div class="flex justify-end mt-4">
                                    <div
                                        class="bg-blue-500 hover:bg-blue-700 text-gray-200 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                                        <button type="submit">
                                            参加
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <form method="GET" action="{{ route('rooms.edit', $room) }}">
                                @csrf
                                <div class="flex justify-end mt-4">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        編集
                                    </button>
                                </div>
                            </form>
                        @endif
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
                </div>
            </div>
        </div>

</x-app-layout>
