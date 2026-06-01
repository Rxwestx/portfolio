<nav x-data="{ open: false }" class="inari-nav sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- App Name -->
                <div class="inari-brand shrink-0 flex items-center text-lg font-semibold text-gray-900">
                    Inari-Path
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('timelogs.create')" :active="request()->routeIs('timelogs.create')">
                        記録入力
                    </x-nav-link>
                    <x-nav-link :href="route('timelogs.index')" :active="request()->routeIs('timelogs.index')" >
                        学習記録一覧
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center rounded-[5px] border border-blade-neon bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-600 transition duration-150 ease-in-out hover:bg-blade-soft hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blade-main focus:ring-offset-2">
                            <div>
                                @if (Auth::check())
                                    {{ Auth::user()->name }}
                                @endif
                            </div>

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
                    class="inline-flex items-center justify-center rounded-[5px] p-2 text-gray-600 transition duration-150 ease-in-out hover:bg-blade-soft hover:text-gray-900 focus:bg-blade-soft focus:outline-none focus:text-gray-900">
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
            <x-responsive-nav-link :href="route('timelogs.create')" :active="request()->routeIs('timelogs.create')">
                記録入力
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('timelogs.index')" :active="request()->routeIs('timelogs.index')">
                学習記録一覧
            </x-responsive-nav-link>
        </div>
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>

        <!-- Responsive Settings Options -->
        <div class="border-t border-blade-neon/40 pb-1 pt-3">
            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
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
