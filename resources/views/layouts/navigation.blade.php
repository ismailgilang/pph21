<div class="fixed flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-800 shadow-lg transform transition-all duration-300 hover:shadow-xl">
        <!-- Sidebar Header with Logo -->
        <div class="p-6 flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md group-hover:rotate-12 transition-transform duration-500">
                <img src="{{asset('images/logo.jpg')}}" class="rounded" alt="">
            </div>
            <h1 class="text-white font-bold text-xl tracking-tight bg-clip-text bg-gradient-to-r from-white to-gray-300 transition-all duration-500 group-hover:text-transparent">Dashboard</h1>
        </div>
        @auth
        <!-- Navigation Menu -->
        <nav class="px-4 space-y-1">
            <!-- Menu Item with Hover Animation -->

            <a href="{{route('dashboard')}}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-indigo-700 translate-x-2' : 'hover:bg-indigo-700 hover:translate-x-2' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-indigo-300 group-hover:text-white' }} transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="{{ request()->routeIs('dashboard') ? 'font-medium' : 'group-hover:font-medium' }} transition-all duration-300">Home</span>
            </a>
            @if(Auth::user()->role === 'keuangan' )
            <div class="relative">
                <a href="{{route('Users.index')}}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 group {{ request()->routeIs('Users.index') ? 'bg-indigo-700 translate-x-2' : 'hover:bg-indigo-700 hover:translate-x-2' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('Users.index') ? 'text-white' : 'text-indigo-300 group-hover:text-white' }} transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap=" round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="{{ request()->routeIs('Users.index') ? 'font-medium' : 'group-hover:font-medium' }} transition-all duration-300">Users</span>
                </a>
            </div>
            @endif

            @if(in_array(Auth::user()->role, ['sdm', 'keuangan']))
            <div class="relative">
                <a href="{{route('Karyawan.index')}}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 group {{ request()->routeIs('Karyawan.index') ? 'bg-indigo-700 translate-x-2' : 'hover:bg-indigo-700 hover:translate-x-2' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('Karyawan.index') ? 'text-white' : 'text-indigo-300 group-hover:text-white' }} transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="{{ request()->routeIs('Karyawan.index') ? 'font-medium' : 'group-hover:font-medium' }} transition-all duration-300">Data Karyawan</span>
                </a>
            </div>
            @endif

            @if(in_array(Auth::user()->role, ['kepala cabang', 'keuangan']))
            <div class="relative">
                <a href="{{route('Bukti.index')}}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 group {{ request()->routeIs('Bukti.index') ? 'bg-indigo-700 translate-x-2' : 'hover:bg-indigo-700 hover:translate-x-2' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('Karyawan.index') ? 'text-white' : 'text-indigo-300 group-hover:text-white' }} transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span class="{{ request()->routeIs('Bukti.index') ? 'font-medium' : 'group-hover:font-medium' }} transition-all duration-300">Upload Bukti</span>
                </a>
            </div>
            @endif

            @if(Auth::user()->role === 'keuangan' )
            <div class="relative">
                <a href="{{route('Penggajian.index')}}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 group {{ request()->routeIs('Penggajian.index') ? 'bg-indigo-700 translate-x-2' : 'hover:bg-indigo-700 hover:translate-x-2' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('Penggajian.index') ? 'text-white' : 'text-indigo-300 group-hover:text-white' }} transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="{{ request()->routeIs('Penggajian.index') ? 'font-medium' : 'group-hover:font-medium' }} transition-all duration-300">Penggajian</span>
                </a>
            </div>
            @endif



            <!-- Menu Item with Submenu Indicator -->
            <!-- <a href="#" class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-indigo-700 hover:translate-x-2 transition-all duration-300 group">
                <svg class="w-5 h-5 mr-3 text-indigo-300 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="group-hover:font-medium transition-all duration-300">Schedule</span>
                <svg class="ml-auto w-4 h-4 transform transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a> -->

            <!-- Menu Item with Notification Badge -->
            <!-- <a href="#" class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-indigo-700 hover:translate-x-2 transition-all duration-300 group">
                <svg class="w-5 h-5 mr-3 text-indigo-300 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="group-hover:font-medium transition-all duration-300">Notifications</span>
                <span class="ml-auto px-2 py-0.5 rounded-full bg-pink-500 text-xs text-white animate-bounce">3</span>
            </a> -->

            <!-- Menu Item with Tooltip Effect -->

        </nav>
        @endauth

        <!-- Sidebar Footer with User Profile -->
        <div class="absolute bottom-0 w-full p-4 border-t border-indigo-700">
            <!-- Profile Dropdown Trigger -->
            <div x-data="{ open: false }" class="relative">
                <button
                    @click="open = !open"
                    class="flex items-center space-x-3 group w-full focus:outline-none">
                    <div class="relative">
                        <img class="w-10 h-10 rounded-full border-2 border-indigo-300 group-hover:border-white transition-colors duration-300"
                            src="https://randomuser.me/api/portraits/women/44.jpg"
                            alt="User profile">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-indigo-800"></span>
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-indigo-200 group-hover:text-white transition-colors duration-300 truncate">
                            {{ Auth::user()->role }}
                        </p>
                    </div>
                    <svg class="w-5 h-5 text-indigo-200 hover:text-white transition-colors duration-300 transform transition-transform"
                        :class="{ 'rotate-180': open }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open"
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute left-0 bottom-full mb-2 w-full origin-bottom-left rounded-md shadow-lg bg-indigo-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-indigo-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>