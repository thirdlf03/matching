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
                        <a href="{{ route('rooms.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">部屋一覧に戻る</a>
                        <div class="flex items-center">
                            <p class="font-bold text-sm lg:text-lg mt-4">募集人数:
                                {{ $room->size }}</p>
                            <p class="font-bold mx-7 text-sm lg:text-lg mt-4">参加中:
                                {{ count($room->room_members) }}</p>
                            <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">部屋名:
                                {{ $room->title }}</p>
                            <p class="text-black mx-7 text-sm sm:block lg:text-lg font-bold mt-4">カテゴリー:
                                {{ $room->category->category_name ?? 'なし' }}</p>

                        </div>

                        @if ($room->user_id == auth()->id())
                            <form method="POST" action="{{ route('rooms.destroy', $room) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">削除</button>
                            </form>
                        @endif
                    </div>

                    @if ($room->room_members->contains(auth()->id()) || $room->user_id == auth()->id())
                        <div x-data="{ slideOverOpen: false }" x-init="@if (session('openChat')) slideOverOpen = true @endif" class="relative z-50 w-auto h-auto">
                            <button @click="slideOverOpen=true; document.body.style.overflow = 'hidden';"
                                    class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">チャット</button>

                            <template x-teleport="body">
                                <div x-show="slideOverOpen"
                                     @keydown.window.escape="slideOverOpen=false; document.body.style.overflow = '';"
                                     x-init="$watch('slideOverOpen', value => { if (value) { setupChatFormSubmission();
                                            scrollToBottom(); } })" class="relative z-[99]">
                                    <div x-show="slideOverOpen" x-transition.opacity.duration.600ms
                                         @click="slideOverOpen=false; document.body.style.overflow = '';"
                                         class="fixed inset-0 bg-black bg-opacity-10"></div>
                                    <div class="fixed inset-0 right-0 flex justify-end">
                                        <div x-show="slideOverOpen"
                                             @click.away="slideOverOpen=false; document.body.style.overflow = '';"
                                             x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                             x-transition:enter-start="translate-x-full"
                                             x-transition:enter-end="translate-x-0"
                                             x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                             x-transition:leave-start="translate-x-0"
                                             x-transition:leave-end="translate-x-full" class="w-screen max-w-md">
                                            <div
                                                class="flex flex-col h-screen bg-white border-l shadow-lg border-neutral-100/70">
                                                <div class="px-4 sm:px-5">
                                                    <div class="flex items-start justify-between pb-1">
                                                        <h2 class="text-base font-semibold leading-6 text-gray-900"
                                                            id="slide-over-title">チャット</h2>
                                                        <div class="flex items-center h-auto ml-3">
                                                            <button
                                                                @click="slideOverOpen = false; document.body.style.overflow = '';"
                                                                class="absolute top-0 right-0 z-30 flex items-center justify-center px-3 py-2 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                     viewBox="0 0 24 24" stroke-width="1.5"
                                                                     stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                                <span>閉じる</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow flex flex-col overflow-hidden px-4 mt-5 sm:px-5">
                                                    <div
                                                        class="flex-grow overflow-hidden border border-dashed rounded-md border-neutral-300">
                                                        <div class="h-full overflow-y-auto p-4" id="scroll">
                                                            <div class="chats space-y-4" id="chat-container">
                                                                @foreach ($chats as $chat)
                                                                    <div
                                                                        class="flex @if ($chat->user_id == auth()->id()) justify-end @else justify-start @endif">
                                                                        @if ($chat->user_id != auth()->id())
                                                                            <div class="text-xs text-gray-600 mb-1">
                                                                                <p>{{ $chat->user->name }}</p>
                                                                                <p>{{ $chat->created_at->format('H:i') }}
                                                                                </p> <!--タイムスタンプを表示する-->
                                                                            </div>
                                                                        @else
                                                                            <p class="text-xs text-gray-600 mb-1">
                                                                                {{ $chat->created_at->format('H:i') }}
                                                                            </p> <!--タイムスタンプの表示-->
                                                                        @endif
                                                                        <div
                                                                            class="bg-gray-100 p-2 rounded-md max-w-xs">
                                                                            <p class="text-sm text-gray-900">
                                                                                {{ $chat->chat }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form method="POST" action="{{ route('chat.store') }}" id="chat-form"
                                                      class="flex-shrink-0 px-4 sm:px-5 mt-5 mb-4">
                                                    @csrf
                                                    <div class="flex">
                                                        <input type="hidden" name="room_id"
                                                               value="{{ $room->id }}">
                                                        <input type="text" name="chat" placeholder="メッセージを入力"
                                                               id="chat-input"
                                                               class="flex-1 w-full px-4 py-2 text-sm border rounded-md focus:ring-2 focus:ring-neutral-200 focus:outline-none">
                                                        <button type="submit"
                                                                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">送信</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    @endif

                    <div class="mt-2 mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg relative">
                        <div id="restored-content-{{ $room->id }}"></div>

                        @if ($room->is_show == 1)
                            <p class="my-2">場所</p>
                            <iframe src="https://maps.google.com/maps?output=embed&q={{ $room->latitude }},{{ $room->longitude }}&ll={{ $room->latitude }},{{ $room->longitude }}&t=m&hl=ja&z=18" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif

                        <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $room->user->name }}</p><br>
                        <p>参加者 ({{ count($room->room_members) }}人)</p>
                        <ul>
                            @foreach ($room->room_members as $member)
                                <li>{{ $member->name }}</li>
                            @endforeach
                        </ul>
                        <br>
                        <!-- ここから投稿タグの作成 -->

                        <!-- Add New Task Button and Modal -->
                        @if ($room->user_id == auth()->id())
                            <div x-data="{ showNewTaskModal: false }">
                                <div class="mt-4">
                                    <button @click="showNewTaskModal = true" class="bg-blue-500 text-white px-4 py-2 rounded">新規作成</button>
                                </div>

                                <!-- New Task Modal -->
                                <div x-show="showNewTaskModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white p-6 rounded shadow-lg">
                                        <h2 class="text-xl mb-4">新しいタスクを作成</h2>
                                        <form method="POST" action="{{ route('room_role.store') }}">
                                            @csrf
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <div class="mb-4">
                                                <label for="role_name" class="block text-sm font-medium text-gray-700">役割名</label>
                                                <input type="text" name="role_name" id="role_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            </div>
                                            <div class="mb-4">
                                                <label for="assigned_member" class="block text-sm font-medium text-gray-700">メンバー</label>
                                                <select name="assigned_member" id="assigned_member" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                    @foreach($room->room_members as $member)
                                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="status" class="block text-sm font-medium text-gray-700">ステータス</label>
                                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                    <option value="未着手">未着手</option>
                                                    <option value="進行中">進行中</option>
                                                    <option value="達成">達成</option>
                                                </select>
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="button" @click="showNewTaskModal = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">キャンセル</button>
                                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">作成</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Task List -->
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">役割</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">ユーザー名</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">ステータス</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr x-data="{ isEditing: false, roleName: '{{ $role->role_name }}', assignedUser: '{{ $role->user_id }}', status: '{{ $role->status }}' }">
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        <span x-show="!isEditing">{{ $role->role_name }}</span>
                                        <input x-show="isEditing" x-model="roleName" type="text" class="w-full border rounded-md" />
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        <span x-show="!isEditing">{{ $role->user ? $role->user->name : '未割り当て' }}</span>
                                        <select x-show="isEditing" x-model="assignedUser" class="w-full border rounded-md">
                                            @foreach($room->room_members as $member)
                                                <option value="{{ $member->id }}" :selected="assignedUser == {{ $member->id }}">{{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        <span x-show="!isEditing">{{ $role->status }}</span>
                                        <select x-show="isEditing" x-model="status" class="w-full border rounded-md">
                                            <option value="未着手">未着手</option>
                                            <option value="進行中">進行中</option>
                                            <option value="達成">達成</option>
                                        </select>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                        @if ($room->user_id == auth()->id())
                                            <button x-show="!isEditing" @click="isEditing = true" class="bg-blue-500 text-white px-2 py-1 rounded">編集</button>
                                            <form x-show="isEditing" method="POST" action="{{ route('room_role.update', $role->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="role_name" :value="roleName">
                                                <input type="hidden" name="user_id" :value="assignedUser">
                                                <input type="hidden" name="status" :value="status">
                                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">保存</button>
                                            </form>
                                            <form method="POST" action="{{ route('room_role.destroy', $role->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">削除</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <script>
                            document.addEventListener('alpine:init', () => {
                                Alpine.data('taskModal', () => ({
                                    showNewTaskModal: false,
                                }));
                            });
                        </script>
                        <style>
                            [x-cloak] { display: none !important; }
                        </style>



                        @if ($room->user_id != auth()->id())
                            @if ($room->room_members->contains(auth()->id()))
                                <form method="POST" action="{{ route('roomMembers.destroy', $room) }}" style="position: absolute; top: 0px; right: 20px;">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-end mt-4">

                                        <div class="bg-red-500 hover:bg-red-700 text-gray-200 font-bold py-0.5 px-1 rounded focus:outline-none focus:shadow-outline">

                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <button type="submit">退室</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                @if(count($room->room_members) < $room->size)
                                <form method="POST" action="{{ route('roomMembers.store') }}">
                                    @csrf
                                    <div class="flex justify-end mt-4">
                                        <div
                                            class="bg-blue-500 hover:bg-blue-700 text-gray-200 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <button type="submit" @if(count($room->room_members) >= $room->size) disabled @endif>参加</button>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            @endif
                        @else
                            <form method="GET" action="{{ route('rooms.edit', $room) }}">
                                @csrf
                                <div class="flex justify-end mt-4">
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">編集</button>
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

                        document.getElementById('getRole').addEventListener('click', function(e) {
                            e.preventDefault();

                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
