<x-app-layout>
    <x-slot name="header">
        <!-- Including Quill and Highlight.js CSS/JS for Text Editor and Syntax Highlighting -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('部屋一覧') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <!-- Back to Top Button -->
        <button id="backToTopBtn"
            class="fixed bottom-8 right-8 p-4 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-500 transition-all ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 11l7-7 7 7M5 19l7-7 7 7" />
            </svg>
        </button>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const backToTopBtn = document.getElementById('backToTopBtn');
                backToTopBtn.addEventListener('click', () => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
        </script>

        <!-- Main container for content -->
        <div class="max-w-7xl mx-auto">
            <!-- Room Creation Button -->
            <div class="flex justify-end">
                <a href="{{ route('rooms.create') }}"
                    class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-300">
                    + 新規作成
                </a>
            </div>

            <!-- Room Listings -->
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($rooms as $room)
                    <div class="flex flex-col justify-between bg-white p-10 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                        
                        <!-- Room Header with Icon and Title -->
                        <div class="flex flex-col items-start mb-4">
                            <h3 class="text-2xl font-bold text-gray-800 text-center">{{ $room->title ?? 'なし' }}</h3>

                            <div class="flex items-center mt-4">
                                
                                <!-- Icon Placeholder (You can replace this with an actual icon if needed) -->
                                <div class="w-12 h-12 bg-grey-400 rounded-full flex items-center justify-center mr-4 mt-2">
                                    <svg class="absolute w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                </div>
                                
                                <!-- Title and Details -->
                                <div class="flex-1">
                                    <a href="{{ route('profile.show', $room->user) }}" class="block mt-1 text-gray-500 text-xl">{{ $room->user->name }}</a>
                                </div>
                            </div>
                            <p class="self-end text-gray-500 text-sm ml-2">{{ $room->created_at->diffForHumans() }}</p>
                        </div>

                        <div class="flex flex-col justify-end">
                            <!-- Room Content -->
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
        </div>
    </div>
</x-app-layout>
