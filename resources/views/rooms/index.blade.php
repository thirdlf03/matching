<x-app-layout>
    <x-slot name="header">
        <!-- Including Quill and Highlight.js CSS/JS for Text Editor and Syntax Highlighting -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ルーム一覧') }}
        </h2>
    </x-slot>

    <div class="mt-12 py-12 px-6 max-w-7xl mx-auto bg-white shadow-sm sm:rounded-lg">
        <!-- Back to Top Button -->
        <!-- Back to Top Button -->
        <button id="backToTopBtn"
            class="fixed bottom-8 right-8 p-4 border-1 border-blue-600 text-blue-600 rounded-full shadow-lg hover:bg-blue-600 hover:text-white transition-all ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
            </svg>
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

        <!-- Room Creation and Toggle for Followed Rooms -->
        <div class="flex justify-between mb-6">
            <a href="{{ route('rooms.create') }}"
                class="border-1 border-blue-600 hover:bg-blue-600 hover:text-white text-blue-600 font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-300">
                + 新規作成
            </a>

            <div x-data="{ switchOn: {{ json_encode(request('followed') ? true : false) }}, clicked: false }" class="flex space-x-2 py-0.75 my-2">
                <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">
                <button x-ref="switchButton" type="button" @click="switchOn = ! switchOn; clicked = true"
                    :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
                    class="relative inline-flex h-6 py-0.5 focus:outline-none rounded-full w-10" id="followedRoomsBtn"
                    data-followed="{{ request('followed') ? 'true' : 'false' }}" x-cloak>
                    <span
                        :class="(switchOn ? 'translate-x-[18px]' : 'translate-x-0.5') + (clicked ? ' duration-200 ease-in-out' :
                            '')"
                        class="w-5 h-5 bg-white rounded-full shadow-md"></span>
                </button>
                <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
                    :class="{ 'text-blue-600': switchOn, 'text-gray-400': !switchOn }" class="text-sm select-none"
                    x-cloak>
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
                        const categoryId = document.getElementById('selected_category_id').value;

                        if (isFollowed) {
                            url.searchParams.delete("followed");
                        } else {
                            url.searchParams.set("followed", "true");
                        }

                        if (categoryId) {
                            url.searchParams.set("category_id", categoryId);
                        }

                        followedRoomsBtn.setAttribute('data-followed', !isFollowed);
                        window.location.href = url.toString();
                    });
                });
            </script>
        </div>

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
            <input type="hidden" name="category_id" id="selected_category_id" value="{{ request('category_id') }}">
            <input type="hidden" name="followed" id="followed" value="{{ request('followed') ? 'true' : 'false' }}">
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
                    const url = new URL("{{ route('rooms.index') }}");
                    const categoryId = this.getAttribute('data-category-id');
                    const isFollowed = document.getElementById('followedRoomsBtn').getAttribute(
                        'data-followed') === 'true';

                    document.querySelectorAll('.category-icon').forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');

                    if (categoryId) {
                        url.searchParams.set("category_id", categoryId);
                    } else {
                        url.searchParams.delete("category_id");
                    }

                    if (isFollowed) {
                        url.searchParams.set("followed", "true");
                    }

                    window.location.href = url.toString();
                });
            });
        </script>

        <!-- Room Listings -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($rooms as $room)
                <div
                    class="flex flex-col justify-between bg-white p-10 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200
                    @if ($room->room_members->contains(auth()->user()->id)) shadow-yellow-500 @endif">

                    <!-- Room Header with Icon and Title -->
                    <div class="flex flex-col items-start mb-4">
                        <h3 class="text-2xl font-bold text-gray-800 text-center">{{ $room->title ?? 'なし' }}</h3>

                        <div class="flex items-center mt-4">
                            @if ($room->user->image_url)
                                <img src="{{ $room->user->image_url }}" alt="{{ $room->user->name }}"
                                    class="w-12 h-12 rounded-full mr-4 mt-2">
                            @else
                                <div
                                    class="w-12 h-12 bg-grey-400 rounded-full flex items-center justify-center mr-4 mt-2">
                                    <svg class="absolute w-10 h-10 text-gray-400" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <a href="{{ route('profile.show', $room->user) }}"
                                class="block mt-1 text-xl
                                        @if ($room->user->points >= 1000) text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600
                                        @elseif($room->user->points >= 500)
                                            text-red-500
                                        @elseif($room->user->points >= 100)
                                            text-blue-700
                                        @else
                                            text-gray-800 dark:text-gray-300 @endif">{{ $room->user->name }}</a>
                        </div>
                        <p class="self-end text-gray-500 text-sm ml-2">{{ $room->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="flex flex-col justify-end">
                        <div id="restored-content-{{ $room->id }}"
                            class="mt-4 text-gray-600 max-h-[128px] overflow-auto"></div>

                        <div class="text-gray-500 text-lg mt-2">
                            <p>参加中: {{ count($room->room_members) }} / {{ $room->size }}</p>
                            {{--                            <p>カテゴリー: {{ $room->category->category_name ?? 'なし' }}</p> --}}
                            @if ($room->date)
                                <p class="font-bold text-sm lg:text-lg mt-4">開催日:{{ $room->date }}</p> <!-- 日付の表示 -->
                            @endif
                        </div>

                        <form method="GET" action="{{ route('rooms.show', $room) }}" class="w-full flex justify-end">
                            @csrf
                            <button type="submit"
                                class="flex self-end px-6 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-300">
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
    </div>
</x-app-layout>
