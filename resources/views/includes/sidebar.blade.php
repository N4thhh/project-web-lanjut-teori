<aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
    <div class="h-16 flex items-center justify-center border-b border-gray-200">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-8 h-8">
            <span class="text-xl font-bold text-blue-600">LaundryKu</span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1">
            
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-6 py-3 transition-colors duration-200 
                   {{ Route::is('admin.dashboard') ? 'text-gray-800 bg-blue-50 border-r-4 border-blue-500' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.layanan') }}" 
                   class="flex items-center px-6 py-3 transition-colors duration-200 
                   {{ Route::is('admin.layanan') ? 'text-gray-800 bg-blue-50 border-r-4 border-blue-500' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Layanan</span>
                </a>
            </li>

            <li>
                <a href="#" 
                   class="flex items-center px-6 py-3 transition-colors duration-200 
                   {{ Route::is('admin.pesanan*') ? 'text-gray-800 bg-blue-50 border-r-4 border-blue-500' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="font-medium">Pesanan</span>
                </a>
            </li>

            <!-- DIBENERIN DI SINI -->
            <li>
                <a href="{{ route('admin.pelanggan') }}" 
                   class="flex items-center px-6 py-3 transition-colors duration-200 
                   {{ Route::is('admin.pelanggan*') ? 'text-gray-800 bg-blue-50 border-r-4 border-blue-500' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium">Pelanggan</span>
                </a>
            </li>

            <li>
                <a href="#" class="flex items-center px-6 py-3 text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium">Laporan</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="border-t border-gray-200 p-4">
        <div class="flex items-center space-x-3 mb-4">
            <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Admin" class="w-10 h-10 rounded-full">
            <div>
                <p class="text-sm font-medium text-gray-800">Admin Laundry</p>
                <p class="text-xs text-gray-500">admin@laundryku.com</p>
            </div>
        </div>
        <a href="{{ route('logout') }}" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"></path>
            </svg>
            Logout
        </a>
    </div>
</aside>
