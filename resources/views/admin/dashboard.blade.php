<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    @include('includes.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

        @php
            $admin = Auth::user();
            $adminName = $admin->name ?? 'Admin';
            $adminAvatar = $admin && $admin->avatar
                ? asset('storage/'.$admin->avatar)
                : 'https://ui-avatars.com/api/?name='.urlencode($adminName).'&background=0D8ABC&color=fff';
        @endphp

        {{-- HEADER --}}
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-3">

                {{-- SEARCH --}}
                <div class="flex items-center bg-gray-100 rounded-lg px-4 py-2 w-64">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input id="searchInput" type="text" placeholder="Cari..."
                           class="bg-transparent border-none focus:outline-none text-sm w-full"
                           onkeyup="filterOrdersTable()">
                </div>

                {{-- USER --}}
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
        </header>

        {{-- MAIN --}}
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

            {{-- CARD SECTION --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <!-- Total Pendapatan -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Total Pendapatan</p>
                            <h3 id="totalPendapatan" class="text-2xl font-bold text-gray-800 mt-1">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="p-2 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pesanan Baru -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Pesanan Baru</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pesananBaru }}</h3>
                        </div>
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pelanggan Aktif -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Pelanggan Aktif</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pelangganAktif }}</h3>
                        </div>
                        <div class="p-2 bg-purple-50 rounded-lg">
                            <svg class="w-6 h-6 text-purple-500" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4z" />
                                <path d="M4 20a8 8 0 1 1 16 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            {{-- PESANAN TERBARU --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Pesanan Terbaru</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500" id="ordersTable">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">ID Pesanan</th>
                                <th class="px-6 py-3">Pelanggan</th>
                                <th class="px-6 py-3">Layanan</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Total</th>
                            </tr>
                        </thead>

                        <tbody>

                        @php
                            function statusColor($status) {
                                return match(strtolower($status)) {
                                    'menunggu_penjemputan' => 'bg-yellow-100 text-yellow-700',
                                    'proses_penimbangan'   => 'bg-orange-100 text-orange-700',
                                    'menunggu_pembayaran'  => 'bg-red-100 text-red-700',
                                    'proses_pencucian'     => 'bg-blue-100 text-blue-700',
                                    'pengiriman'           => 'bg-indigo-100 text-indigo-700',
                                    'selesai'              => 'bg-green-100 text-green-700',
                                    'diambil'              => 'bg-purple-100 text-purple-700',
                                    'dibatalkan'           => 'bg-gray-200 text-gray-700',
                                    default                => 'bg-gray-100 text-gray-700'
                                };
                            }
                        @endphp

                        @forelse($pesananTerbaru as $order)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    #{{ strtoupper(substr($order->id, 0, 8)) }}
                                </td>

                                <td class="px-6 py-4">{{ $order->user->name ?? '-' }}</td>

                                <td class="px-6 py-4">
                                    {{ $order->orderDetails->first()->laundryService->nama_layanan ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium px-2.5 py-1 rounded {{ statusColor($order->status_pesanan) }}">
                                        {{ $order->status_pesanan }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">
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

{{-- SCRIPT --}}
<script>
    function updateTotalPendapatan() {
        axios.get("{{ route('admin.totalPendapatan') }}")
            .then(function(response) {
                const total = response.data.totalPendapatan;
                document.getElementById('totalPendapatan').innerText =
                    'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            })
            .catch(function(error) {
                console.error('Gagal mengambil total pendapatan:', error);
            });
    }
    setInterval(updateTotalPendapatan, 5000);

    function filterOrdersTable() {
        const filter = document.getElementById("searchInput").value.toLowerCase();
        const trs = document.querySelectorAll("#ordersTable tbody tr");
        trs.forEach(tr => {
            const text = tr.innerText.toLowerCase();
            tr.style.display = text.includes(filter) ? "" : "none";
        });
    }
</script>

</body>
</html>
