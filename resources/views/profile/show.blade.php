<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('アカウント詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('rooms.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>
                    <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $user->name }}</p>
                    <div class="text-gray-600 dark:text-gray-400 text-sm">
                        <p>アカウント作成日時: {{ $user->created_at->format('Y-m-d H:i') }}</p>
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

                    <a href="{{ route('profile.following', $user) }}" class="text-gray-900 mb-3">
                        フォロー中: {{ $user->follows->count() }}
                    </a><br>

                    <a href="{{ route('profile.followers', $user) }}" class="text-gray-900 mb-3">
                        フォロワー: {{ $user->followers->count() }}
                    </a>

                    @if ($rooms->count())
                        <!-- ページネーション -->
                        <div class="mb-4">
                            {{ $rooms->appends(request()->input())->links() }}
                        </div>

                        @foreach ($rooms as $room)
                            <div class="flex items-center">
                                <p class="font-bold text-sm lg:text-lg mt-4">募集人数: {{ $room->size }}</p>
                                <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">部屋名:
                                    {{ $room->title }}</p>
                            </div>
                            <div class="mt-2 mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <div id="restored-content-{{ $room->id }}"></div>
                                <a href="{{ route('profile.show', $room->user) }}">
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $room->user->name }}
                                    </p>
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
</x-app-layout>
