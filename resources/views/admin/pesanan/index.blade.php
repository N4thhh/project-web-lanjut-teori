<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan - Admin LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR SAMA PERSIS DENGAN DASHBOARD --}}
    @include('includes.sidebar')

    {{-- BAGIAN KANAN --}}
    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

        @php
            $admin = Auth::user();
            $adminName = $admin->name ?? 'Admin';
            $adminAvatar = $admin && $admin->avatar
                ? asset('storage/'.$admin->avatar)
                : 'https://ui-avatars.com/api/?name='.urlencode($adminName).'&background=0D8ABC&color=fff';
        @endphp

        {{-- HEADER SAMA PERSIS DENGAN DASHBOARD --}}
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-3">
                <form method="GET" class="flex items-center bg-gray-100 rounded-lg px-4 py-2 w-64">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari..."
                        class="bg-transparent border-none focus:outline-none text-sm w-full"
                    >
                </form>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <img
                            src="{{ $adminAvatar }}"
                            alt="{{ $adminName }}"
                            class="w-8 h-8 rounded-full object-cover"
                        >
                        <a href="{{ route('admin.profile') }}"
                           class="text-sm font-medium text-gray-700 hover:text-gray-900">
                            {{ $adminName }}
                        </a>
                    </div>
                </div>
            </div>
        </header>

        {{-- KONTEN UTAMA PESANAN --}}
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Data Pesanan</h1>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Daftar Pesanan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Pelanggan</th>
                                <th class="px-6 py-3">Layanan</th>   {{-- kolom baru --}}
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Pembayaran</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    {{-- ID PESANAN --}}
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        #{{ $order->id }}
                                    </td>

                                    {{-- NAMA PELANGGAN --}}
                                    <td class="px-6 py-4">
                                        {{ $order->user->name ?? '-' }}
                                    </td>

                                    {{-- LAYANAN --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $services = $order->orderDetails
                                                ->map(function ($detail) {
                                                    return $detail->laundryService->nama_layanan
                                                        ?? $detail->laundryService->nama
                                                        ?? $detail->laundryService->name
                                                        ?? null;
                                                })
                                                ->filter()
                                                ->unique()
                                                ->implode(', ');
                                        @endphp

                                        {{ $services ?: '-' }}
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="px-6 py-4">
                                        {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-6 py-4">
                                        @php 
                                            $s = $order->status_pesanan ?? 'menunggu_penjemputan';
                                            $badgeClass = match($s) {
                                                'menunggu_penjemputan' => 'bg-yellow-100 text-yellow-800',
                                                'proses_penimbangan'   => 'bg-orange-100 text-orange-800',
                                                'menunggu_pembayaran'  => 'bg-red-100 text-red-800',
                                                'proses_pencucian'     => 'bg-blue-100 text-blue-800',
                                                'pengiriman'           => 'bg-indigo-100 text-indigo-800',
                                                'selesai'    => 'bg-green-100 text-green-800',
                                                'diambil'    => 'bg-purple-100 text-purple-800',
                                                'dibatalkan' => 'bg-gray-200 text-gray-800',
                                                default      => 'bg-gray-100 text-gray-800',
                                            };
                                            $label = ucwords(str_replace('_', ' ', $s));
                                        @endphp
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded {{ $badgeClass }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                        
                                    {{-- TOTAL HARGA --}}
                                    <td class="px-6 py-4">
                                        Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                                    </td>

                                    {{-- STATUS PEMBAYARAN --}}
                                    <td class="px-6 py-4">
                                        @if($order->payment)
                                            <span class="text-xs font-semibold text-green-600">
                                                {{ ucfirst($order->payment->status) }}
                                            </span>
                                        @else
                                            <span class="text-xs font-medium text-orange-500">
                                                Belum dibayar
                                            </span>
                                        @endif
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    {{-- sekarang ada 8 kolom --}}
                                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada pesanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>
