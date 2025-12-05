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
            <div class="mx-6 mt-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('status'))
            <div class="mx-6 mt-4 bg-red-100 text-red-800 px-4 py-2 rounded-lg text-sm">
                {{ $errors->first('status') }}
            </div>
        @endif

        {{-- KONTEN DETAIL --}}
        <main class="w-full flex-grow p-6 space-y-6">

            {{-- Judul + tombol kembali + tombol edit --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-1">Detail Pesanan</h1>
                    <p class="text-sm text-gray-500">
                        ID Pesanan: <span class="font-mono">#{{ $order->id }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.orders.index') }}"
                       class="text-sm text-gray-600 hover:text-gray-800">
                        &larr; Kembali ke Daftar
                    </a>
                    <a href="{{ route('admin.orders.edit', $order) }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        Edit Pesanan
                    </a>
                </div>
            </div>

            <div class="flex justify-between items-center gap-3">
                            <span class="text-gray-500">Status</span>
                            {{-- UBAH: logic php dipindah inline atau diatas --}}
                            @php
                                $s = $order->status_pesanan; // UBAH: status_pesanan
                                $badgeClass = match($s) {
                                    'menunggu_penjemputan' => 'bg-yellow-100 text-yellow-800', // Tambah ini
                                    'pending'    => 'bg-yellow-100 text-yellow-800',
                                    'proses'     => 'bg-blue-100 text-blue-800',
                                    'selesai'    => 'bg-green-100 text-green-800',
                                    'diambil'    => 'bg-purple-100 text-purple-800',
                                    'dibatalkan' => 'bg-red-100 text-red-800',
                                    default      => 'bg-gray-100 text-gray-800',
                                };
                                $label = ($s == 'menunggu_penjemputan') ? 'Menunggu Penjemputan' : ucfirst($s);
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                {{ $label }}
                            </span>
                        </div>

                <div class="text-sm text-gray-600 space-y-2">
                    {{-- TANGGAL --}}
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal</span>
                        <span>{{ optional($order->created_at)->format('d M Y H:i') ?? '-' }}</span>
                    </div>

                    {{-- STATUS (YANG DIPERBAIKI) --}}
                    <div class="flex justify-between items-center gap-3">
                        <span class="text-gray-500">Status</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                            {{ $label }}
                        </span>
                    </div>

                    {{-- TOTAL --}}
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total</span>
                        <span class="font-semibold">
                            Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Info pelanggan --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-3">
                    <h2 class="text-sm font-semibold text-gray-700 mb-1">Pelanggan</h2>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama</span>
                            <span>{{ optional($order->user)->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email</span>
                            <span>{{ optional($order->user)->email ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Telepon</span>
                            <span>{{ optional($order->user)->phone ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Info pembayaran --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-3">
                    <h2 class="text-sm font-semibold text-gray-700 mb-1">Pembayaran</h2>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Status</span>
                            @if($order->payment)
                                <span class="text-xs font-semibold text-green-600">
                                    {{ ucfirst($order->payment->status) }}
                                </span>
                            @else
                                <span class="text-xs font-medium text-orange-500">
                                    Belum dibayar
                                </span>
                            @endif
                        </div>

                        @if($order->payment)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Metode</span>
                                <span>{{ $order->payment->method ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kode Transaksi</span>
                                <span class="text-xs">
                                    {{ $order->payment->transaction_code ?? '-' }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tabel item layanan --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Item Layanan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Layanan</th>
                                <th class="px-6 py-3">Keterangan</th>
                                <th class="px-6 py-3">Jumlah / Berat</th>
                                <th class="px-6 py-3">Harga Satuan</th>
                                <th class="px-6 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($order->orderDetails ?? []) as $detail)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        {{ optional($detail->laundryService)->nama_layanan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $detail->keterangan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $detail->quantity ?? $detail->berat ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada detail item untuk pesanan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        <div class="mt-8 bg-white p-6 rounded-lg shadow border">
            <h3 class="text-lg font-bold mb-4">Verifikasi Pembayaran</h3>
                    
            @if($order->payment && $order->payment->bukti_pembayaran)
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/3">
                        <p class="text-sm text-gray-500 mb-2">Bukti Upload:</p>
                        <a href="{{ asset('storage/' . $order->payment->bukti_pembayaran) }}" target="_blank">
                            <img src="{{ asset('storage/' . $order->payment->bukti_pembayaran) }}" class="w-full rounded border hover:opacity-90">
                        </a>
                    </div>
                    
                    <div class="w-full md:w-2/3">
                        <p class="mb-2">Metode: <strong>{{ $order->payment->metode_pembayaran }}</strong></p>
                        <p class="mb-4">Status Saat Ini: 
                            <span class="px-2 py-1 rounded text-xs font-bold 
                                {{ $order->status_pembayaran == 'lunas' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ strtoupper($order->status_pembayaran) }}
                            </span>
                        </p>
                    
                        @if($order->status_pembayaran !== 'lunas')
                            <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700" onclick="return confirm('Yakin validasi pembayaran ini?')">
                                    ✅ Verifikasi Lunas
                                </button>
                            </form>
                        @else
                            <div class="p-3 bg-green-50 text-green-700 rounded border border-green-200">
                                Pembayaran sudah diverifikasi.
                            </div>
                        @endif
                    </div>
                </div>
            @else
            <p class="text-gray-500 italic">Belum ada bukti pembayaran yang diupload customer.</p>
            @endif
        </div>
        </main>
    </div>
</div>

</body>
</html>
