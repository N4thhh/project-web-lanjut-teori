<header class="bg-white shadow flex items-center justify-between px-8 py-2">
    <div class="flex items-center space-x-3">
        <img src="{{ asset('images/Logo.png') }}" alt="LaundryKu Logo" class="h-12 w-12">
        <span class="text-2xl font-bold text-primary">LaundryKu</span>
    </div>

    <nav class="flex space-x-2 md:space-x-6 items-center">
        
        {{-- DASHBOARD --}}
        <a href="{{ route('customer.dashboard') }}"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold
           {{ Route::is('customer.dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="2"/>
                <rect x="14" y="3" width="7" height="7" rx="2"/>
                <rect x="14" y="14" width="7" height="7" rx="2"/>
                <rect x="3" y="14" width="7" height="7" rx="2"/>
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- LAYANAN --}}
        <a href="{{ route('customer.layanan') }}"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold
           {{ Route::is('customer.layanan') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-handshake"><path d="M19.414 14.414C21 12.828 22 11.5 22 9.5a5.5 5.5 0 0 0-9.591-3.676.6.6 0 0 1-.818.001A5.5 5.5 0 0 0 2 9.5c0 2.3 1.5 4 3 5.5l5.535 5.362a2 2 0 0 0 2.879.054 2.12 2.12 0 0 0-.004-3 2.124 2.124 0 1 0 3-3 2.124 2.124 0 0 0 3.004 0 2 2 0 0 0 0-2.828l-1.881-1.882a2.41 2.41 0 0 0-3.409 0l-1.71 1.71a2 2 0 0 1-2.828 0 2 2 0 0 1 0-2.828l2.823-2.762"/></svg>
            <span>Layanan</span>
        </a>

        {{-- RIWAYAT PESANAN --}}
        <a href="{{ route('customer.riwayat-pesanan') }}"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold
           {{ Route::is('customer.riwayat-pesanan') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M9 12l2 2 4-4M7 20h10a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Riwayat Pesanan</span>
        </a>

        {{-- PROFIL --}}
        <a href="{{ route('customer.profile') }}"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold
           {{ Route::is('customer.profile') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M5.121 17.804A8 8 0 0112 16a8 8 0 016.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Profile</span>
        </a>

    </nav>

    <div class="flex items-center space-x-3">
        <div class="flex items-center space-x-2">
            <span class="bg-primary rounded-full p-2 flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M16 14a4 4 0 01-8 0"/>
                    <circle cx="12" cy="8" r="4"/>
                </svg>
            </span>
            <span class="text-gray-600 font-medium">{{ Auth::user()->name }}</span>
        </div>

        <a href="{{ route('logout') }}" class="bg-primary hover:bg-primary-hover text-white px-6 py-2 rounded-lg flex items-center space-x-2 transition">
            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
            </svg>
            <span>Logout</span>
        </a>
    </div>
</header>
