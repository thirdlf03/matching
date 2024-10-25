<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('部屋一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <button id="backToTopBtn"
            class="border-2 border-blue-300 text-blue-300 font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline hover:bg-blue-300 hover:text-white fixed bottom-5 right-5 bg-transparent">
            上に戻る
        </button>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const backToTopBtn = document.getElementById('backToTopBtn');

                backToTopBtn.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });
        </script>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a class="p-2 mb-2" href="{{ route('rooms.create') }}">+ 新規作成</a>
                    <div x-data="{ switchOn: {{ request('followed') ? 'true' : 'false' }}, clicked: false }" class="flex space-x-2 py-0.75 my-2">
                        <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">

                        <button x-ref="switchButton" type="button" @click="switchOn = ! switchOn; clicked = true"
                            :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
                            class="relative inline-flex h-6 py-0.5 focus:outline-none rounded-full w-10"
                            id="followedRoomsBtn" data-followed="{{ request('followed') ? 'true' : 'false' }}" x-cloak>
                            <span
                                :class="(switchOn ? 'translate-x-[18px]' : 'translate-x-0.5') + (clicked ?
                                    ' duration-200 ease-in-out' : '')"
                                class="w-5 h-5 bg-white rounded-full shadow-md"></span>
                        </button>

                        <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
                            :class="{ 'text-blue-600': switchOn, 'text-gray-400': !switchOn }"
                            class="text-sm select-none" x-cloak>
                            フォロー中
                        </label>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const backToTopBtn = document.getElementById('backToTopBtn');
                            backToTopBtn.addEventListener('click', () => {
                                window.scrollTo({
                                    top: 0,
                                    behavior: 'smooth'
                                });
                            });

                            const followedRoomsBtn = document.getElementById('followedRoomsBtn');
                            followedRoomsBtn.setAttribute('data-followed', "{{ request('followed') ? 'true' : 'false' }}");
                            followedRoomsBtn.addEventListener('click', function() {
                                const url = new URL("{{ route('rooms.index') }}");
                                const isFollowed = followedRoomsBtn.getAttribute('data-followed') === 'true';
                                if (isFollowed) {
                                    url.searchParams.delete("followed");
                                } else {
                                    url.searchParams.set("followed", "true");
                                }
                                followedRoomsBtn.setAttribute('data-followed', !isFollowed);
                                window.location.href = url;
                            });
                        });
                    </script>

                    <form id="categoryForm" action="{{ route('rooms.index') }}" method="GET" class="mb-6">
                        <div class="flex flex-wrap">
                            <div class="w-22 h-8 rounded-full border border-black p-1 m-1 cursor-pointer category-icon flex items-center justify-center {{ is_null(request('category_id')) ? 'selected' : '' }}"
                                data-category-id="">
                                <h3 class="text-xs font-semibold text-center">すべてのカテゴリー</h3>
                            </div>
                            @foreach ($categories as $category)
                                <div class="w-22 h-8 rounded-full border border-black p-1 m-1 cursor-pointer category-icon flex items-center justify-center {{ request('category_id') == $category->id ? 'selected' : '' }}"
                                    data-category-id="{{ $category->id }}">
                                    <h3 class="text-xs font-semibold text-center">{{ $category->category_name }}</h3>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="category_id" id="selected_category_id"
                            value="{{ request('category_id') }}">
                    </form>
                    <style>
                        .selected {
                            background-color: #0000FF;
                            /* Blue color */
                            color: #fff;
                            /* Change text color if needed */
                        }
                    </style>
                    <script>
                        document.querySelectorAll('.category-icon').forEach(icon => {
                            icon.addEventListener('click', function() {
                                document.querySelectorAll('.category-icon').forEach(i => i.classList.remove('selected'));
                                this.classList.add('selected');
                                document.getElementById('selected_category_id').value = this.getAttribute(
                                    'data-category-id');
                                document.getElementById('categoryForm').submit();
                            });
                        });
                    </script>

                    @foreach ($rooms as $room)
                        <div class="flex items-center">
                            <p class="font-bold text-sm lg:text-lg mt-4">募集人数: {{ $room->size }}</p>
                            <p class="font-bold mx-7 text-sm lg:text-lg mt-4">参加中:
                                {{ count($room->room_members) }}</p>
                            <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">部屋名:
                                {{ $room->title }}</p>
                            <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">カテゴリー:
                                {{ $room->category->category_name ?? 'なし' }}</p>
                            <p class="font-bold text-sm lg:text-lg mt-4">開催日:{{ $room->date }}</p> <!-- 日付の表示 -->

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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
