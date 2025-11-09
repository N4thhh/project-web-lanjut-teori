<header class="bg-white shadow flex items-center justify-between px-8 py-2">
    <!-- Logo dan Judul -->
    <div class="flex items-center space-x-3">
        <div class="bg-blue-400 p-3 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 12v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7M7 10V7a3 3 0 116 0v3M17 10V7a3 3 0 00-6 0v3M12 19v-7"/>
            </svg>
        </div>
        <span class="text-2xl font-bold text-blue-400">LaundryKu</span>
    </div>
    <!-- Navigation dengan highlight menu aktif -->
    <nav class="flex space-x-2 md:space-x-6 items-center">
        <a href="/dashboard"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold
           {{ (isset($activeMenu) && $activeMenu === 'dashboard') || Route::is('customer.dashboard') ? 'bg-blue-50 text-blue-400' : 'text-gray-600 hover:text-blue-400' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="2"/>
                <rect x="14" y="3" width="7" height="7" rx="2"/>
                <rect x="14" y="14" width="7" height="7" rx="2"/>
                <rect x="3" y="14" width="7" height="7" rx="2"/>
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="/layanan"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold
           {{ (isset($activeMenu) && $activeMenu === 'layanan') || Route::is('customer.layanan') ? 'bg-blue-50 text-blue-400' : 'text-gray-600 hover:text-blue-400' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364A4.5 4.5 0 004.318 6.318z"/>
            </svg>
            <span>Layanan</span>
        </a>
        <a href="/riwayat"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold
           {{ (isset($activeMenu) && $activeMenu === 'riwayat') || Route::is('customer.riwayat') ? 'bg-blue-50 text-blue-400' : 'text-gray-600 hover:text-blue-400' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M9 12l2 2 4-4M7 20h10a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Riwayat Pesanan</span>
        </a>
        <a href="/profil"
           class="flex items-center space-x-2 px-3 py-2 rounded-xl font-semibold
           {{ (isset($activeMenu) && $activeMenu === 'profil') || Route::is('customer.profil') ? 'bg-blue-50 text-blue-400' : 'text-gray-600 hover:text-blue-400' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M5.121 17.804A8 8 0 0112 16a8 8 0 016.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Profil</span>
        </a>
    </nav>
    <!-- Profil dan Logout (Kanan) -->
    <div class="flex items-center space-x-3">
        <div class="flex items-center space-x-2">
            <span class="bg-blue-400 rounded-full p-2 flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M16 14a4 4 0 01-8 0"/>
                    <circle cx="12" cy="8" r="4"/>
                </svg>
            </span>
            <span class="text-gray-600 font-medium">{{ Auth::user()->name }}</span>
        </div>
        <a href="{{ route('logout') }}" class="bg-blue-400 hover:bg-blue-500 text-white px-6 py-2 rounded-lg flex items-center space-x-2 transition">
            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
            </svg>
            <span>Logout</span>
        </a>
    </div>
</header>
