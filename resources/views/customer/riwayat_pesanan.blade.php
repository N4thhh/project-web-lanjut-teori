<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - LaundryKu</title>
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
<body class="bg-gray-50 min-h-screen">

@include('includes.header')

<main class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Riwayat Pesanan</h1>
        <p class="text-gray-600 text-sm">
            Daftar semua pesanan laundry yang dibuat oleh akun ini.
        </p>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-2xl p-6 shadow-sm text-center text-gray-500">
            Belum ada pesanan. Silakan buat pesanan melalui menu
            <span class="font-semibold text-primary">Layanan</span>.
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-primary/5">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">ID Pesanan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Total</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($orders as $order)
                        @php
                            // Mapping status pesanan ke display text
                            $statusDisplay = match($order->status_pesanan) {
                                'menunggu_penjemputan' => 'Menunggu Penjemputan',
                                'pending' => 'Pending',
                                'proses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                                'diambil' => 'Sudah Diambil',
                                'dibatalkan' => 'Dibatalkan',
                                default => 'Unknown'
                            };

                            // Mapping status pembayaran ke display text
                            $pembayaranDisplay = match($order->status_pembayaran) {
                                'belum_bayar' => 'Belum Bayar',
                                'sudah_bayar' => 'Sudah Bayar',
                                'lunas' => 'Lunas',
                                default => 'Belum Bayar'
                            };
                        @endphp
                        <tr class="hover:bg-primary/5">
                            <td class="px-4 py-3 font-mono text-gray-800">{{ $order->id }}</td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                    @if($order->status_pesanan === 'menunggu_penjemputan') bg-yellow-100 text-yellow-700
                                    @elseif($order->status_pesanan === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status_pesanan === 'proses') bg-blue-100 text-blue-700
                                    @elseif($order->status_pesanan === 'selesai') bg-emerald-100 text-emerald-700
                                    @elseif($order->status_pesanan === 'diambil') bg-purple-100 text-purple-700
                                    @elseif($order->status_pesanan === 'dibatalkan') bg-red-100 text-red-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ $statusDisplay }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-900">
                                Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
<td class="px-4 py-3">
                                {{-- LOGIKA TOMBOL BAYAR --}}
                                @if($order->status_pesanan !== 'menunggu_penjemputan' && 
                                    $order->status_pesanan !== 'pending' && 
                                    $order->status_pesanan !== 'dibatalkan' && 
                                    $order->status_pembayaran === 'belum_bayar' &&
                                    $order->total_harga > 0)
                                    
                                    {{-- Tombol muncul jika sudah ditimbang (bukan menunggu/pending) & belum bayar --}}
                                    <a href="{{ route('customer.payment.show', $order->id) }}" 
                                       class="inline-block bg-blue-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-blue-600 transition shadow-sm">
                                       Bayar Sekarang
                                    </a>

                                @elseif($order->status_pembayaran === 'sudah_bayar')
                                    <span class="text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded border border-blue-100">
                                        Menunggu Verifikasi
                                    </span>
                                
                                @else
                                    {{-- Tampilkan Badge Status Pembayaran Biasa --}}
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                        @if($order->status_pembayaran === 'lunas') bg-green-100 text-green-700
                                        @else bg-orange-100 text-orange-600 @endif">
                                        {{-- Fallback tampilan teks --}}
                                        {{ $order->status_pembayaran == 'belum_bayar' ? 'Belum Bayar' : ucfirst($order->status_pembayaran) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</main>

@include('includes.footer')

</body>
</html>