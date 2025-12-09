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
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Layanan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status Pesanan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Total</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($orders as $order)
                        @php
                            // 1. Mapping Label Status (Sesuai Alur Baru)
                            $statusLabel = match($order->status_pesanan) {
                                'menunggu_penjemputan' => 'Menunggu Penjemputan',
                                'proses_penimbangan'   => 'Sedang Ditimbang',
                                'menunggu_pembayaran'  => 'Menunggu Pembayaran',
                                'proses_pencucian'     => 'Sedang Dicuci',
                                'pengiriman'           => 'Sedang Dikirim',
                                'selesai'              => 'Selesai',
                                'diambil'              => 'Sudah Diambil',
                                'dibatalkan'           => 'Dibatalkan',
                                default                => ucfirst(str_replace('_', ' ', $order->status_pesanan))
                            };

                            // 2. Mapping Warna Badge Status
                            $statusClass = match($order->status_pesanan) {
                                'menunggu_penjemputan' => 'bg-yellow-100 text-yellow-700',
                                'proses_penimbangan'   => 'bg-orange-100 text-orange-700',
                                'menunggu_pembayaran'  => 'bg-red-100 text-red-700',
                                'proses_pencucian'     => 'bg-blue-100 text-blue-700',
                                'pengiriman'           => 'bg-indigo-100 text-indigo-700',
                                'selesai'              => 'bg-green-100 text-green-700',
                                'diambil'              => 'bg-purple-100 text-purple-700',
                                'dibatalkan'           => 'bg-gray-200 text-gray-700',
                                default                => 'bg-gray-100 text-gray-600'
                            };
                        @endphp

                        <tr class="hover:bg-primary/5 transition">
                            {{-- ID Pesanan --}}
                            <td class="px-4 py-3 font-mono text-gray-800">
                                #{{ substr($order->id, 0, 8) }}
                            </td>

                            {{-- Layanan (kolom baru) --}}
                            <td class="px-4 py-3 text-gray-700">
                                @php
                                    $layanans = $order->orderDetails
                                        ->map(function ($detail) {
                                            return $detail->laundryService->nama_layanan ?? 'Layanan';
                                        })
                                        ->unique()
                                        ->values()
                                        ->all();
                                @endphp

                                {{ $layanans ? implode(', ', $layanans) : '-' }}
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-4 py-3 text-gray-700">
                                {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                            </td>

                            {{-- Status, Total, Pembayaran dibiarkan persis seperti punyamu --}}
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-900">
                                Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                {{-- blok logika tombol bayar PUNYAMU, jangan diubah --}}
                                @if($order->status_pesanan === 'menunggu_pembayaran' && $order->status_pembayaran === 'belum_bayar')
                                    <a href="{{ route('customer.payment.show', $order->id) }}" 
                                    class="inline-block bg-blue-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-blue-600 transition shadow-sm">
                                    Bayar Sekarang
                                    </a>
                                @elseif($order->status_pembayaran === 'sudah_bayar')
                                    <span class="text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded border border-blue-100">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($order->status_pembayaran === 'lunas')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        Lunas
                                    </span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-600">
                                        Belum Bayar
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
