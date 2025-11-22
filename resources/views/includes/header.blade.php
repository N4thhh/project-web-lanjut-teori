<header class="bg-white shadow flex items-center justify-between px-8 py-2 relative z-20">
    <div class="flex items-center space-x-3">
        <img src="{{ asset('images/Logo.png') }}" alt="LaundryKu Logo" class="h-12 w-12">
        <span class="text-2xl font-bold text-primary">LaundryKu</span>
    </div>

    <nav class="hidden md:flex space-x-2 lg:space-x-6 items-center">
        {{-- Dashboard --}}
        <a href="{{ route('customer.dashboard') }}"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold transition
           {{ (isset($activeMenu) && $activeMenu === 'dashboard') || Route::is('customer.dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="2"/>
                <rect x="14" y="3" width="7" height="7" rx="2"/>
                <rect x="14" y="14" width="7" height="7" rx="2"/>
                <rect x="3" y="14" width="7" height="7" rx="2"/>
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- Layanan --}}
        <a href="{{ route('customer.layanan') }}"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold transition
           {{ (isset($activeMenu) && $activeMenu === 'layanan') || Route::is('customer.layanan') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary' }}">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
            </svg>
            <span>Layanan</span>
        </a>

        {{-- Riwayat Pesanan --}}
        <a href="{{ route('customer.riwayat-pesanan') }}"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold transition
           {{ (isset($activeMenu) && $activeMenu === 'riwayat') || Route::is('customer.riwayat-pesanan') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M9 12l2 2 4-4M7 20h10a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Riwayat Pesanan</span>
        </a>

        {{-- Profil (Menu) --}}
        <a href="{{ route('customer.profile') }}"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold transition
           {{ (isset($activeMenu) && $activeMenu === 'profil') || Route::is('customer.profile') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M5.121 17.804A8 8 0 0112 16a8 8 0 016.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Profil</span>
        </a>
    </nav>

    <div class="flex items-center space-x-3 lg:space-x-5">
        
        <a href="{{ route('customer.cart.index') }}" 
           class="relative p-2 rounded-full hover:bg-gray-100 transition group {{ Route::is('customer.cart.index') ? 'text-primary bg-primary/5' : 'text-gray-500' }}" title="Keranjang">
            <svg class="h-6 w-6 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            {{-- Badge Jumlah Item --}}
            @php
                $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
            @endphp
            @if($cartCount > 0)
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full shadow-sm border-2 border-white">
                    {{ $cartCount }}
                </span>
            @endif
        </a>

        <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>

        <div class="flex items-center space-x-3">
            <div class="hidden sm:flex items-center space-x-2">
                <span class="bg-primary rounded-full p-1.5 flex items-center justify-center">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M16 14a4 4 0 01-8 0"/>
                        <circle cx="12" cy="8" r="4"/>
                    </svg>
                </span>
                <span class="text-gray-700 font-medium text-sm">{{ Auth::user()->name }}</span>
            </div>
            
            <a href="{{ route('logout') }}" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition text-sm shadow-sm shadow-primary/30">
                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
                </svg>
                <span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </div>
</header>