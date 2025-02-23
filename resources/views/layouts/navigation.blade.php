<nav x-data="{ open: false }" class="bg-white text-white border-b border-gray-00 h-15 ">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <h1 class="text-xl text-black font-semibold hover:text-gray-600 transition">
                            Cepat Kaya
                        </h1>
                        <!-- Navigation Links (Desktop) -->
                        <div class="hidden sm:flex space-x-8 ml-10">
                            <x-nav-link :href="route('dashboard')" 
                                :active="request()->routeIs('dashboard')" 
                                class="relative group text-black font-semibold px-4 py-2 transition duration-300">
                                <span class="relative z-10 group-hover:text-white transition duration-300">{{ __('Dashboard') }}</span>
                                <span class="absolute inset-0 bg-black rounded-md scale-0 group-hover:scale-100 transition-transform duration-300"></span>
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-black scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </x-nav-link>
                        
                            {{-- <x-nav-link :href="route('transactions.index')" 
                                :active="request()->routeIs('transactions.*')" 
                                class="relative group text-black font-semibold px-4 py-2 transition duration-300">
                                <span class="relative z-10 group-hover:text-white transition duration-300">{{ __('Transaksi') }}</span>
                                <span class="absolute inset-0 bg-black rounded-md scale-0 group-hover:scale-100 transition-transform duration-300"></span>
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-black scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </x-nav-link> --}}
                        
                            {{-- <x-nav-link :href="route('saving-targets.index')" 
                                :active="request()->routeIs('saving-targets.index')" 
                                class="relative group text-black font-semibold px-4 py-2 transition duration-300">
                                <span class="relative z-10 group-hover:text-white transition duration-300">{{ __('Target Tabungan') }}</span>
                                <span class="absolute inset-0 bg-black rounded-md scale-0 group-hover:scale-100 transition-transform duration-300"></span>
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-black scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </x-nav-link> --}}
                        </div>
                    </div>
        
                    <!-- User Dropdown (Desktop) -->
                    <div class="hidden sm:flex items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center px-3 py-2 text-black hover:text-gray-600 transition">
                                    <div>{{ Auth::user()->name }}</div>
                                    <svg class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
        
                    <!-- Mobile Menu Button -->
                    <div class="sm:hidden flex items-center">
                        <button @click="open = ! open" class="text-black hover:text-gray-600 transition">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'block': ! open}" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'block': open}" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white text-black p-4">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block py-2 hover:text-gray-400 transition">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        {{-- <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="block py-2 hover:text-gray-400 transition">
            {{ __('Transaksi') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('saving-targets.index')" :active="request()->routeIs('saving-targets.index')" class="block py-2 hover:text-gray-400 transition">
            {{ __('Target Tabungan') }}
        </x-responsive-nav-link> --}}
    
        <!-- Dropdown Profil dan Logout -->
        <div x-data="{ openDropdown: false }" class="mt-2">
            <button @click="openDropdown = !openDropdown" class="flex items-center justify-between w-full px-4 py-2 text-left text-gray-700 hover:text-gray-400 transition">
                <span>{{ Auth::user()->name }}</span>
                <svg :class="{'rotate-180': openDropdown}" class="w-4 h-4 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
    
            <div x-show="openDropdown" x-cloak class="mt-1 bg-gray-100 rounded-md shadow-lg">
                <x-responsive-nav-link :href="route('profile.edit')" class="block px-4 py-2 hover:bg-gray-200">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 hover:bg-gray-200">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    
</nav>