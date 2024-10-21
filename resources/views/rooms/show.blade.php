<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
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
                            <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">部屋名: {{ $room->title }}</p>
                        </div>

                        @if ($room->user_id == auth()->id())
                            <form method="POST" action="{{ route('rooms.destroy', $room) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">削除</button>
                            </form>
                        @endif
                    </div>

                    @if ($room->room_members->contains(auth()->id()) || $room->user_id == auth()->id())
                        <div x-data="{ slideOverOpen: false }" x-init="@if (session('openChat')) slideOverOpen = true @endif" class="relative z-50 w-auto h-auto">
                            <button @click="slideOverOpen=true; document.body.style.overflow = 'hidden';" class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">チャット</button>

                            <template x-teleport="body">
                                <div x-show="slideOverOpen" @keydown.window.escape="slideOverOpen=false; document.body.style.overflow = '';" x-init="$watch('slideOverOpen', value => { if (value) { setupChatFormSubmission(); scrollToBottom(); } })" class="relative z-[99]">
                                    <div x-show="slideOverOpen" x-transition.opacity.duration.600ms @click="slideOverOpen=false; document.body.style.overflow = '';" class="fixed inset-0 bg-black bg-opacity-10"></div>
                                    <div class="fixed inset-0 right-0 flex justify-end">
                                        <div x-show="slideOverOpen" @click.away="slideOverOpen=false; document.body.style.overflow = '';" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md">
                                            <div class="flex flex-col h-screen bg-white border-l shadow-lg border-neutral-100/70">
                                                <div class="px-4 sm:px-5">
                                                    <div class="flex items-start justify-between pb-1">
                                                        <h2 class="text-base font-semibold leading-6 text-gray-900" id="slide-over-title">チャット</h2>
                                                        <div class="flex items-center h-auto ml-3">
                                                            <button @click="slideOverOpen = false; document.body.style.overflow = '';" class="absolute top-0 right-0 z-30 flex items-center justify-center px-3 py-2 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                                <span>閉じる</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow flex flex-col overflow-hidden px-4 mt-5 sm:px-5">
                                                    <div class="flex-grow overflow-hidden border border-dashed rounded-md border-neutral-300">
                                                        <div class="h-full overflow-y-auto p-4" id="scroll">
                                                            <div class="chats space-y-4" id="chat-container">
                                                                @foreach ($chats as $chat)
                                                                    <div class="flex @if($chat->user_id == auth()->id()) justify-end @else justify-start @endif">
                                                                        @if($chat->user_id != auth()->id())
                                                                            <p class="text-xs text-gray-600 mb-1">{{ $chat->user->name }}</p>
                                                                        @endif
                                                                        <div class="bg-gray-100 p-2 rounded-md max-w-xs">
                                                                            <p class="text-sm text-gray-900">{{ $chat->chat }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form method="POST" action="{{ route('chat.store') }}" id="chat-form" class="flex-shrink-0 px-4 sm:px-5 mt-5 mb-4">
                                                    @csrf
                                                    <div class="flex">
                                                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                                                        <input type="text" name="chat" placeholder="メッセージを入力" id="chat-input" class="flex-1 w-full px-4 py-2 text-sm border rounded-md focus:ring-2 focus:ring-neutral-200 focus:outline-none">
                                                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">送信</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    @endif

                    <div class="mt-2 mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <div id="restored-content-{{ $room->id }}"></div>
                        <p class="my-2">場所</p>
                        <iframe src="https://maps.google.com/maps?output=embed&q={{ $room->latitude }},{{ $room->longitude }}&ll={{ $room->latitude }},{{ $room->longitude }}&t=m&hl=ja&z=18" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $room->user->name }}</p><br>
                        <p>参加者<br>
                            @foreach ($room->room_members as $member)
                                ・{{ $member->name }}
                                <br>
                            @endforeach
                        </p>
                        @if ($room->user_id != auth()->id())
                            @if ($room->room_members->contains(auth()->id()))
                                <form method="POST" action="{{ route('roomMembers.destroy', $room) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-end mt-4">
                                        <div class="bg-red-500 hover:bg-red-700 text-gray-200 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <button type="submit">退室</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form method="POST" action="{{ route('roomMembers.store') }}">
                                    @csrf
                                    <div class="flex justify-end mt-4">
                                        <div class="bg-blue-500 hover:bg-blue-700 text-gray-200 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <button type="submit">参加</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @else
                            <form method="GET" action="{{ route('rooms.edit', $room) }}">
                                @csrf
                                <div class="flex justify-end mt-4">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">編集</button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <script>
                        var content_text = '{!! $room->data_json !!}';
                        var json = content_text.replace(/\n/g, '\\n');
                        var authenticatedUserId = {{ auth()->id() }};
                        json = JSON.parse(json);
                        const restoredContent{{ $room->id }} = new Quill('#restored-content-{{ $room->id }}');
                        restoredContent{{ $room->id }}.setContents(json);
                        restoredContent{{ $room->id }}.disable();

                        function setupChatFormSubmission() {
                            const chatForm = document.getElementById('chat-form');
                            if (chatForm) {
                                chatForm.addEventListener('submit', handleChatFormSubmit);
                            }
                        }

                        function handleChatFormSubmit(event) {
                            event.preventDefault();
                            const submitButton = this.querySelector('button[type="submit"]');
                            submitButton.disabled = true; // Disable the submit button
                            const formData = new FormData(this);
                            fetch(this.action, {
                                method: this.method,
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                }
                            })
                                .then(response => {
                                    if (response.ok) {
                                        document.getElementById('chat-input').value = ''; // Clear the chat input
                                        scrollToBottom(); // Scroll to the bottom of the chat
                                    }
                                    submitButton.disabled = false; // Re-enable the submit button
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    submitButton.disabled = false; // Re-enable the submit button in case of error
                                });
                        }

                        function scrollToBottom() {
                            const chatContainer = document.getElementById('scroll');
                            setTimeout(() => {
                                chatContainer.scrollTop = chatContainer.scrollHeight;
                            }, 100); // Add a delay to ensure the DOM updates properly
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
