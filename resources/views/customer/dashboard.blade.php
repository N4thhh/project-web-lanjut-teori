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

    <main class="max-w-7xl mx-auto px-4 py-6">

        <!-- Greeting -->
        <div class="rounded-2xl bg-gradient-to-r from-[#2697db] to-[#4ec3f7] px-8 py-7 mb-7 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-1">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>
                <p class="text-white opacity-80">Kelola pesanan laundry Anda dengan mudah dan praktis</p>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/4775/4775255.png" class="w-32 hidden md:block"/>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

            {{-- Total Pesanan --}}
            <div class="bg-white rounded-xl shadow flex flex-col items-center py-7">
                <div class="bg-blue-100 p-3 rounded-full mb-2">
                    <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2"/>
                    </svg>
                </div>
                <div class="text-md font-semibold">Total Pesanan</div>
                <div class="text-2xl font-bold mt-1">{{ $totalOrders }}</div>
            </div>

            {{-- Pesanan Aktif --}}
            <div class="bg-white rounded-xl shadow flex flex-col items-center py-7">
                <div class="bg-orange-100 p-3 rounded-full mb-2">
                    <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <div class="text-md font-semibold">Pesanan Aktif</div>
                <div class="text-2xl font-bold mt-1">{{ $activeOrders }}</div>
            </div>

            {{-- Pesanan Selesai --}}
            <div class="bg-white rounded-xl shadow flex flex-col items-center py-7">
                <div class="bg-green-100 p-3 rounded-full mb-2">
                    <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>
                </div>
                <div class="text-md font-semibold">Pesanan Selesai</div>
                <div class="text-2xl font-bold mt-1">{{ $completedOrders }}</div>
            </div>

        </div>

        <!-- Pesanan Terbaru -->
        <div class="mb-10">

            <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-lg">Pesanan Terbaru</h3>
                <a href="{{ route('customer.riwayat_pesanan') }}"
                   class="text-primary hover:underline font-semibold flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4" stroke="currentColor" fill="none" stroke-width="2">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow divide-y">

                @forelse ($latestOrders as $order)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4">
                        <div>

                            <div class="font-semibold">
                                {{
                                    optional($order->orderDetails->first())->laundryService->nama_layanan
                                    ?? 'Tidak Ada Layanan'
                                }}
                            </div>

                            <div class="text-[13px] text-gray-500 flex gap-4 mt-1">
                                <span>🗓 {{ $order->created_at->format('Y-m-d') }}</span>
                                <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                <span class="text-primary underline">#{{ $order->id }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:items-end">

                            @php
                                $badgeColor = [
                                    'menunggu_penjemputan' => 'bg-yellow-100 text-yellow-700',
                                    'diproses'             => 'bg-blue-100 text-blue-700',
                                    'siap_diambil'         => 'bg-indigo-100 text-indigo-700',
                                    'selesai'              => 'bg-green-100 text-green-700',
                                ][$order->status_pesanan] ?? 'bg-gray-100 text-gray-600';
                            @endphp

                            <span class="px-3 py-1 mb-2 rounded-full text-sm font-semibold {{ $badgeColor }}">
                                {{ ucfirst(str_replace('_',' ', $order->status_pesanan)) }}
                            </span>

                            <!-- PERBAIKAN DI SINI -->
                            <a href="{{ route('customer.riwayat_pesanan') }}"
                               class="px-4 py-1 border border-primary text-primary rounded-lg text-sm hover:bg-primary hover:text-white transition">
                                Detail
                            </a>
                        </div>
                    </div>

                @empty
                    <div class="p-5 text-gray-500 text-center">
                        Belum ada pesanan.
                    </div>
                @endforelse

            </div>
        </div>

        <!-- Tips Perawatan -->
        <h3 class="font-semibold text-lg mb-3">Tips Perawatan Pakaian</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-blue-50 p-6 rounded-xl shadow">
                <div class="font-bold mb-1">Pisahkan Berdasarkan Warna</div>
                <p class="text-sm text-gray-600">
                    Selalu pisahkan pakaian putih, terang, dan gelap agar warna tidak tercampur.
                </p>
            </div>

            <div class="bg-green-50 p-6 rounded-xl shadow">
                <div class="font-bold mb-1">Gunakan Suhu Air yang Tepat</div>
                <p class="text-sm text-gray-600">
                    Air dingin untuk pakaian berwarna, air hangat untuk pakaian putih.
                </p>
            </div>

            <div class="bg-orange-50 p-6 rounded-xl shadow">
                <div class="font-bold mb-1">Jangan Menunda Mencuci</div>
                <p class="text-sm text-gray-600">
                    Pakaian kotor yang lama dibiarkan dapat meninggalkan noda membandel.
                </p>
            </div>
        </div>

    </main>

    @include('includes.footer')

</body>
</html>
