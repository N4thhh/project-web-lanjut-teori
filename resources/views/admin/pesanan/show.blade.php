<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Admin LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    @include('includes.sidebar')

    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

        {{-- HEADER --}}
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-3">
                <div class="flex items-center bg-gray-100 rounded-lg px-4 py-2 w-64">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Cari..." class="bg-transparent border-none focus:outline-none text-sm w-full">
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Admin" class="w-8 h-8 rounded-full">
                        <span class="text-sm font-medium text-gray-700">Admin</span>
                    </div>
                </div>
            </div>
        </header>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="mx-6 mt-4 bg-green-100 text-green-800 px-4 py-3 rounded-lg shadow-sm border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 mt-4 bg-red-100 text-red-800 px-4 py-3 rounded-lg shadow-sm border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mx-6 mt-4 bg-red-100 text-red-800 px-4 py-3 rounded-lg text-sm shadow-sm border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- KONTEN DETAIL --}}
        <main class="w-full flex-grow p-6 space-y-6">

            {{-- Judul + tombol kembali + tombol edit --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-1">Detail Pesanan</h1>
                    <p class="text-sm text-gray-500">
                        ID Pesanan: <span class="font-mono">#{{ Str::limit($order->id, 8, '...') }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.orders.index') }}"
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('admin.orders.edit', $order) }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Pesanan
                    </a>
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Info Umum --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-3">
                    <h2 class="text-sm font-semibold text-gray-700 mb-1 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Info Pesanan
                    </h2>
                    <div class="text-sm text-gray-600 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal</span>
                            <span class="font-medium">{{ optional($order->created_at)->format('d M Y H:i') ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center gap-3">
                            <span class="text-gray-500">Status</span>
                            @php
                                $s = $order->status_pesanan ?? 'menunggu_penjemputan';
                                $label = ucwords(str_replace('_', ' ', $s));
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
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                {{ $label }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total</span>
                            <span class="font-semibold text-lg text-blue-600">
                                Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Info pelanggan --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-3">
                    <h2 class="text-sm font-semibold text-gray-700 mb-1 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Info Pelanggan
                    </h2>
                    <div class="text-sm text-gray-600 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama</span>
                            <span class="font-medium">{{ optional($order->user)->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email</span>
                            <span class="text-xs">{{ optional($order->user)->email ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Alamat</span>
                            <span class="text-xs text-right max-w-[150px]">{{ Str::limit($order->alamat ?? '-', 50) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Info pembayaran --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-3">
                    <h2 class="text-sm font-semibold text-gray-700 mb-1 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Info Pembayaran
                    </h2>
                    <div class="text-sm text-gray-600 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status</span>
                            @if($order->payment)
                                @php
                                    $statusPayment = $order->payment->status;
                                    $badgePayment = match($statusPayment) {
                                        'lunas' => 'bg-green-100 text-green-700 border-green-200',
                                        'menunggu_verifikasi' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'belum_bayar' => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgePayment }}">
                                    {{ ucfirst(str_replace('_', ' ', $statusPayment)) }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                    Belum Dibayar
                                </span>
                            @endif
                        </div>

                        @if($order->payment)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Metode</span>
                                <span class="font-medium">{{ $order->payment->metode_pembayaran ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Jumlah</span>
                                <span class="font-semibold">Rp {{ number_format($order->payment->jumlah_bayar ?? 0, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tabel item layanan --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Item Layanan
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3">Layanan</th>
                                <th class="px-6 py-3">Keterangan</th>
                                <th class="px-6 py-3 text-center">Jumlah / Berat</th>
                                <th class="px-6 py-3 text-right">Harga Satuan</th>
                                <th class="px-6 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse(($order->orderDetails ?? []) as $detail)
                                <tr class="bg-white hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ optional($detail->laundryService)->nama_layanan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $detail->keterangan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-50 text-blue-700">
                                            {{ number_format($detail->berat ?? 0, 1) }} kg
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono text-gray-700">
                                        Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            Tidak ada detail item untuk pesanan ini.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($order->orderDetails && $order->orderDetails->count() > 0)
                            <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-700">
                                        Total Keseluruhan:
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-lg text-blue-600">
                                        Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Verifikasi Pembayaran --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Verifikasi Pembayaran
                </h3>
                        
                @if($order->payment && $order->payment->bukti_pembayaran)
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-1/3">
                            <p class="text-sm text-gray-500 mb-2 font-medium">Bukti Upload:</p>
                            <a href="{{ asset('storage/' . $order->payment->bukti_pembayaran) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/' . $order->payment->bukti_pembayaran) }}" 
                                     class="w-full rounded-lg border-2 border-gray-200 hover:border-blue-400 transition shadow-sm hover:shadow-md" 
                                     alt="Bukti Pembayaran">
                            </a>
                        </div>
                        
                        <div class="w-full md:w-2/3 space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Metode Pembayaran</p>
                                <p class="font-semibold text-gray-800">{{ ucwords(str_replace('_', ' ', $order->payment->metode_pembayaran)) }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Jumlah Transfer</p>
                                <p class="font-bold text-xl text-blue-600">Rp {{ number_format($order->payment->jumlah_bayar, 0, ',', '.') }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Status Saat Ini</p>
                                @php
                                    $statusPaymentBadge = match($order->status_pembayaran) {
                                        'lunas' => 'bg-green-100 text-green-700 border-green-300',
                                        'sudah_bayar' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                        default => 'bg-orange-100 text-orange-700 border-orange-300',
                                    };
                                @endphp
                                <span class="inline-block px-4 py-2 rounded-lg text-sm font-bold border-2 {{ $statusPaymentBadge }}">
                                    {{ strtoupper(str_replace('_', ' ', $order->status_pembayaran)) }}
                                </span>
                            </div>
                        
                            @if($order->status_pembayaran !== 'lunas')
                                <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition shadow-lg flex items-center" 
                                            onclick="return confirm('Yakin validasi pembayaran ini sebagai LUNAS?')">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Verifikasi Lunas
                                    </button>
                                </form>
                            @else
                                <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-center">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-semibold">Pembayaran sudah diverifikasi dan tercatat sebagai LUNAS.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 italic">Belum ada bukti pembayaran yang diupload customer.</p>
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>

</body>
</html>