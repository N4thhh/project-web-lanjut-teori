<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer - LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#4FC3F7',
                        'primary-hover': '#25B6F5',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Header --}}
    @include('includes.header')

    {{-- Content --}}
    <main class="max-w-7xl mx-auto px-4 py-6">
        <!-- Greeting -->
        <div class="rounded-2xl bg-gradient-to-r from-[#2697db] to-[#4ec3f7] px-8 py-7 mb-7 relative flex items-center justify-between overflow-hidden">
            <div>
                <h2 class="text-2xl font-bold text-white mb-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <div class="text-white text-[15px] opacity-80">
                    Kelola pesanan laundry Anda dengan mudah dan praktis
                </div>
            </div>
            <div class="hidden md:block">
                <img src="https://cdn-icons-png.flaticon.com/512/4775/4775255.png" alt="Laundry" class="w-32"/>
            </div>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow flex flex-col items-center py-7">
                <div class="bg-blue-100 p-3 rounded-full mb-2">
                    <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2"/>
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                    </svg>
                </div>
                <div class="text-md font-semibold text-gray-700">Total Pesanan</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">24</div>
            </div>
            <div class="bg-white rounded-xl shadow flex flex-col items-center py-7">
                <div class="bg-orange-100 p-3 rounded-full mb-2">
                    <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <div class="text-md font-semibold text-gray-700">Pesanan Aktif</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">3</div>
            </div>
            <div class="bg-white rounded-xl shadow flex flex-col items-center py-7">
                <div class="bg-green-100 p-3 rounded-full mb-2">
                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                </div>
                <div class="text-md font-semibold text-gray-700">Pesanan Selesai</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">21</div>
            </div>
            <div class="bg-white rounded-xl shadow flex flex-col items-center py-7">
                <div class="bg-purple-100 p-3 rounded-full mb-2">
                    <svg class="h-6 w-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                </div>
                <div class="text-md font-semibold text-gray-700">Total Pengeluaran</div>
                <div class="text-2xl font-bold text-purple-700 mt-1">Rp 2.450.000</div>
            </div>
        </div>
        
        <!-- Pesanan Terbaru -->
        <div class="mb-10">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold text-lg">Pesanan Terbaru</h3>
                <a href="#" class="text-primary font-semibold flex items-center space-x-1 hover:underline">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="bg-white rounded-xl shadow divide-y">
                <!-- Pesanan 1 -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4">
                    <div>
                        <div class="font-semibold">Cuci Kering Premium</div>
                        <div class="text-[13px] text-gray-500 flex items-center space-x-4">
                            <span><svg class="h-4 w-4 inline-block mr-1 align-sub" fill="none" viewBox="0 0 24 24" stroke-width="2"><path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>2024-01-05</span>
                            <span>Rp 65.000</span>
                            <span class="underline text-primary">#OK-001</span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:items-end">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700 mb-2">Dalam Proses</span>
                        <a href="#" class="px-4 py-1 rounded-lg border border-primary text-primary font-medium hover:bg-primary hover:text-white transition text-sm">Detail</a>
                    </div>
                </div>
                <!-- Pesanan 2 -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4">
                    <div>
                        <div class="font-semibold">Setrika Express</div>
                        <div class="text-[13px] text-gray-500 flex items-center space-x-4">
                            <span><svg class="h-4 w-4 inline-block mr-1 align-sub" fill="none" viewBox="0 0 24 24" stroke-width="2"><path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>2024-01-14</span>
                            <span>Rp 45.000</span>
                            <span class="underline text-primary">#OK-002</span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:items-end">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 mb-2">Siap Diambil</span>
                        <a href="#" class="px-4 py-1 rounded-lg border border-primary text-primary font-medium hover:bg-primary hover:text-white transition text-sm">Detail</a>
                    </div>
                </div>
                <!-- Pesanan 3 -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4">
                    <div>
                        <div class="font-semibold">Dry Clean Jas</div>
                        <div class="text-[13px] text-gray-500 flex items-center space-x-4">
                            <span><svg class="h-4 w-4 inline-block mr-1 align-sub" fill="none" viewBox="0 0 24 24" stroke-width="2"><path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>2024-01-03</span>
                            <span>Rp 120.000</span>
                            <span class="underline text-primary">#OR-003</span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:items-end">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700 mb-2">Selesai</span>
                        <a href="#" class="px-4 py-1 rounded-lg border border-primary text-primary font-medium hover:bg-primary hover:text-white transition text-sm">Detail</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips Perawatan -->
        <div class="mb-8">
            <h3 class="font-semibold text-lg mb-3">Tips Perawatan Pakaian</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-xl bg-blue-50 p-6 shadow flex flex-col">
                    <div class="mb-3">
                        <span class="inline-block bg-blue-100 text-blue-400 p-2 rounded-full">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 7h18M3 12h18M3 17h18"/>
                            </svg>
                        </span>
                    </div>
                    <div class="font-bold mb-1 text-gray-700">Pisahkan Berdasarkan Warna</div>
                    <div class="text-sm text-gray-600">Selalu pisahkan pakaian putih, berwarna terang, dan gelap untuk hasil terbaik.</div>
                </div>
                <div class="rounded-xl bg-green-50 p-6 shadow flex flex-col">
                    <div class="mb-3">
                        <span class="inline-block bg-green-100 text-green-400 p-2 rounded-full">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M8 19h8M9 4v2m6-2v2m-7 5h10M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/>
                            </svg>
                        </span>
                    </div>
                    <div class="font-bold mb-1 text-gray-700">Perhatikan Suhu Air</div>
                    <div class="text-sm text-gray-600">Gunakan air dingin untuk pakaian berwarna dan air hangat untuk pakaian putih.</div>
                </div>
                <div class="rounded-xl bg-orange-50 p-6 shadow flex flex-col">
                    <div class="mb-3">
                        <span class="inline-block bg-orange-100 text-orange-400 p-2 rounded-full">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M8 17v-7m8 7v-4m-8 4a4 4 0 108 0"/>
                            </svg>
                        </span>
                    </div>
                    <div class="font-bold mb-1 text-gray-700">Jangan Tunda Mencuci</div>
                    <div class="text-sm text-gray-600">Segera cuci pakaian kotor untuk mencegah noda membandel dan bau tidak sedap.</div>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    @include('includes.footer')

</body>
</html>
