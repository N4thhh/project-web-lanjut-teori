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
<script>
function confirmUbahStatus(form) {
    let ok = confirm("Yakin ingin mengubah status pesanan ini?");
    if (ok) {
        form.submit();
    } else {
        location.reload();
    }
}
</script>

<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR (sama seperti dashboard & index pesanan) --}}
    @include('includes.sidebar')

    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

        {{-- HEADER (copy dari dashboard) --}}
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
        @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        {{-- KONTEN DETAIL --}}
        <main class="w-full flex-grow p-6 space-y-6">

            {{-- Judul + tombol kembali --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-1">Detail Pesanan</h1>
                    <p class="text-sm text-gray-500">
                        ID Pesanan: <span class="font-mono">#{{ $order->id }}</span>
                    </p>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                   class="text-sm text-blue-600 hover:text-blue-800">
                    &larr; Kembali ke Daftar Pesanan
                </a>
            </div>

            {{-- Kartu ringkasan --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Info pesanan --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-3">
                    <h2 class="text-sm font-semibold text-gray-700 mb-1">Informasi Pesanan</h2>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal</span>
                            <span>{{ optional($order->created_at)->format('d M Y H:i') ?? '-' }}</span>
                        </div>

                        @php $s = $order->status; @endphp
                        @php
                            $badgeClass = match($s) {
                                'pending'    => 'bg-yellow-100 text-yellow-800',
                                'proses'     => 'bg-blue-100 text-blue-800',
                                'selesai'    => 'bg-green-100 text-green-800',
                                'diambil'    => 'bg-purple-100 text-purple-800',
                                'dibatalkan' => 'bg-red-100 text-red-800',
                                default      => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status</span>

                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <select name="status"
                                        onchange="confirmUbahStatus(this.form)"
                                        class="text-xs px-2 py-1 border rounded-lg bg-white">
                                    <option value="pending"    {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="proses"     {{ $order->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="selesai"    {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="diambil"    {{ $order->status == 'diambil' ? 'selected' : '' }}>Diambil</option>
                                    <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </form>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Total</span>
                            <span class="font-semibold">
                                Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
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
  
        </main>
    </div>
</div>

</body>
</html>
