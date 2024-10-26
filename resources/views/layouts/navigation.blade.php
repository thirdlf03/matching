<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">

                    <a href="{{ route('dashboard') }}">
                        <!-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" /> -->
                        <svg class="h-12" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                            <g fill="none" fill-rule="evenodd">
                                <path stroke="#979797" stroke-linecap="round" stroke-width="2"
                                    d="M30.9918831 54.5548089L30.9918831 59.9498999M28.6188673 12.1237581L24 5" />
                                <path stroke="#979797" stroke-linecap="round" stroke-width="2"
                                    d="M38.6188673,12.1237581 L34,5" transform="matrix(-1 0 0 1 72.619 0)" />
                                <circle cx="48" cy="33" r="12" fill="#B4DFFB" />
                                <circle cx="15" cy="33" r="12" fill="#B4DFFB" />
                                <path fill="#FFAF40"
                                    d="M22,19.9989419 C22,15.0289635 26.0283444,11 31,11 L31,11 C35.9705627,11 40,15.0204204 40,19.9989419 L40,43 L22,43 L22,19.9989419 Z" />
                                <path fill="#595959"
                                    d="M22,43 L40,43 L40,49 C40,52.3137085 37.3052181,55 34.0062606,55 L27.9937394,55 C24.6834885,55 22,52.3069658 22,49 L22,43 Z" />
                                <rect width="18" height="4" x="22" y="35" fill="#595959" />
                                <rect width="18" height="4" x="22" y="27" fill="#595959" />
                            </g>
                        </svg>
                    </a>

                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')">
                        {{ __('部屋一覧') }}
                    </x-nav-link>
                    <x-nav-link :href="route('rooms.search')" :active="request()->routeIs('rooms.search')">
                        {{ __('部屋検索') }}
                    </x-nav-link>
                    <x-nav-link :href="route('profile.show', auth()->user())" :active="request()->routeIs('profile.show')">
                        {{ __('アカウント詳細') }}
                    </x-nav-link>
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')">
                {{ __('部屋一覧') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('rooms.search')" :active="request()->routeIs('rooms.search')">
                {{ __('部屋検索') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile.show', auth()->user())" :active="request()->routeIs('profile.show')">
                {{ __('User詳細') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
