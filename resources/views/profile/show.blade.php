<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('アカウント詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex px-4">
                        <div class="flex flex-col pr-8">
                            <a href="{{ route('rooms.index') }}"
                                class="text-blue-500 hover:text-blue-700 mr-2">部屋一覧に戻る</a>
                                
                            <p class="text-gray-800 dark:text-gray-300 text-4xl py-4">{{ $user->name }}</p>
                            <div class="text-gray-600 dark:text-gray-400 text-sm">
                                <p>アカウント作成日時: {{ $user->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <!-- Following Count -->
                        <div class="flex items-center justify-center space-x-8 mb-4 mt-4">
                            <!-- Following Count on the Left -->
                            <div class="text-center flex flex-col items-center">
                                <a href="{{ route('profile.following', $user) }}"
                                    class="text-gray-800 dark:text-gray-300">
                                    <span class="text-4xl font-bold">{{ $user->follows->count() }}</span>
                                    <span class="text-sm">フォロー中</span>
                                </a>
                            </div>

                            <div class="text-center flex flex-col items-center">
                                <a href="{{ route('profile.followers', $user) }}"
                                    class="text-gray-800 dark:text-gray-300">
                                    <span class="text-4xl font-bold">{{ $user->followers->count() }}</span>
                                    <span class="text-sm">フォロワー</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($user->id !== auth()->id())
                        <div class="text-gray-900 dark:text-gray-100">
                            @if ($user->followers->contains(auth()->id()))
                                <form action="{{ route('follow.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">フォローをやめる</button>
                                </form>
                            @else
                                <form action="{{ route('follow.store', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">フォローする</button>
                                </form>
                            @endif
                        </div>
                    @endif

                    <div class="flex flex-wrap lg:flex-nowrap">
                        <div class="w-full lg:w-1/2 p-4">
                            <h3 class="text-lg font-semibold mb-4">現在のルーム</h3>
                            @if ($rooms->count())
                                @foreach ($rooms as $room)
                                    <div class="flex items-center">
                                        <p class="font-bold text-sm lg:text-lg mt-4">募集人数: {{ $room->size }}</p>
                                        <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">ルーム名:
                                            {{ $room->title }}</p>
                                    </div>
                                    <div class="mt-2 mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <div id="restored-content-{{ $room->id }}"></div>
                                        <a href="{{ route('profile.show', $room->user) }}">
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者:
                                                {{ $room->user->name }}</p>
                                        </a>
                                        <form method="GET" action="{{ route('rooms.show', $room) }}">
                                            @csrf
                                            <div class="flex justify-end mt-4">
                                                <button type="submit"
    class="flex self-end px-6 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-300">
    詳細
</button>

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
                            @else
                                <p>No rooms found.</p>
                            @endif
                        </div>

                        <div class="w-full lg:w-1/2 p-4 lg:border-l lg:border-gray-300 dark:border-gray-600">
                            <h3 class="text-lg font-semibold mb-4">過去作ったルーム</h3>
                            @if ($archives->count())
                                @foreach ($archives as $archive)
                                    <div class="flex items-center">
                                        <p class="font-bold text-sm lg:text-lg mt-4">募集人数: {{ $archive->size }}</p>
                                        <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">ルーム名:
                                            {{ $archive->title }}</p>
                                    </div>
                                    <div class="mt-2 mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <div id="restored-content-{{ $archive->id }}"></div>
                                        <a href="{{ route('profile.show', $archive->user) }}">
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者:
                                                {{ $archive->user->name }}</p>
                                        </a>
                                    </div>
                                    <script>
                                        var content_text = '{!! $archive->data_json !!}';
                                        var json = content_text.replace(/\n/g, '\\n');
                                        json = JSON.parse(json);
                                        const restoredContent{{ $archive->id }} = new Quill('#restored-content-{{ $archive->id }}');
                                        restoredContent{{ $archive->id }}.setContents(json);
                                        console.log(json);
                                        restoredContent{{ $archive->id }}.disable();
                                    </script>
                                @endforeach
                            @else
                                <p>No archived rooms found.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
