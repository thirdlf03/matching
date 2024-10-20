<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }} のフォロワー一覧
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($followers as $follower)
                        <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <!-- フォロワーの名前 -->
                            <p class="font-semibold text-black dark:text-white">{{ $follower->name }}</p>

                            <!--詳細ページ -->
                            <a href="{{ route('profile.show', $follower) }}" class="text-blue-500 hover:text-blue-700">
                                詳細を見る
                                <!--フォローとフォロワー数-->
                                <p class="text-black dark:text-white">
                                    followers: {{ $follower->followers->count() }}
                                </p>
                                <p class="text-black dark:text-white">
                                    following: {{ $follower->follows->count() }}
                                </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
