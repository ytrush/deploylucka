<nav x-data="{ open: false }" class="absolute top-0 left-0 right-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        @if(request()->routeIs('analytics') || request()->routeIs('roadmap') || request()->routeIs('courses.*'))
                            <img src="{{ asset('images/Primary-Edumora-Putih.png') }}" alt="Edumora Logo" class="h-9 w-auto" />
                        @else
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        @endif
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">
                        {{ __('Courses') }}
                    </x-nav-link>

                    <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
                        {{ __('Artikel') }}
                    </x-nav-link>

                    <x-nav-link :href="route('roadmap')" :active="request()->routeIs('roadmap')">
                        {{ __('Roadmap') }}
                    </x-nav-link>

                    <x-nav-link :href="route('analytics')" :active="request()->routeIs('analytics')">
                        {{ __('Analytics') }}
                    </x-nav-link>

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 bg-white/70 backdrop-blur-sm hover:bg-white/90 border border-white/50 rounded-full pl-2 pr-4 py-1.5 transition-all duration-300 hover:shadow-md">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-gray-900 leading-tight">{{ Auth::user()->name }}</p>
                            </div>
                            <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- User Info Header -->
                        <div class="px-4 py-3 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-900 text-sm">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 px-4 py-2.5">
                                <i class="ti ti-user text-gray-400"></i>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50">
                                    <i class="ti ti-logout text-red-400"></i>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-black hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-black transition duration-150 ease-in-out">
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
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white/95 backdrop-blur-sm border-b border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                {{ __('Categories') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">
                {{ __('Courses') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
                {{ __('Artikel') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('roadmap')" :active="request()->routeIs('roadmap')">
                {{ __('Roadmap') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('analytics')" :active="request()->routeIs('analytics')">
                {{ __('Analytics') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('sections.index')" :active="request()->routeIs('sections.*')">
                {{ __('Sections') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('materis.index')" :active="request()->routeIs('materis.*')">
                {{ __('Materi') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-bold shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center gap-2">
                    <i class="ti ti-user"></i>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center gap-2 text-red-600 hover:bg-red-50">
                        <i class="ti ti-logout"></i>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
