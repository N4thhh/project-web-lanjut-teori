<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Admin LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50">

<div class="flex h-screen overflow-hidden">
    @include('includes.sidebar')

    <div class="relative flex flex-col flex-1 overflow-y-auto">
        
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-3">
                <h1 class="text-xl font-semibold text-gray-800">Detail Pesanan</h1>
                <div class="flex items-center space-x-4">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Admin" class="w-8 h-8 rounded-full">
                    <span class="text-sm font-medium text-gray-700">Admin</span>
                </div>
            </div>
        </header>

        <main class="w-full flex-grow p-6">
            
            <a href="{{ route('admin.pesanan.index') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Pesanan
            </a>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Informasi Pelanggan
                        </h2>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nama:</span>
                                <span class="font-medium text-gray-800">{{ $order->user->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Email:</span>
                                <span class="font-medium text-gray-800">{{ $order->user->email ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">ID Pesanan:</span>
                                <span class="font-mono text-xs text-gray-600">{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal Pesan:</span>
                                <span class="font-medium text-gray-800">{{ $order->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Alamat Penjemputan
                        </h2>
                        <p class="text-gray-700">{{ $order->alamat }}</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Item Pesanan
                        </h2>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Layanan</th>
                                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Harga/Kg</th>
                                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Jumlah</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-600">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($order->orderDetails as $detail)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-800">{{ $detail->laundryService->nama_layanan ?? 'Layanan' }}</div>
                                            <div class="text-xs text-gray-500">{{ Str::limit($detail->laundryService->deskripsi ?? '', 50) }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center font-mono text-gray-700">
                                            Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if($detail->jumlah > 0)
                                                <span class="font-semibold text-gray-800">{{ $detail->jumlah }} kg</span>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Belum ditimbang</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right font-semibold text-gray-800">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Tidak ada item</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-800">TOTAL:</td>
                                        <td class="px-4 py-4 text-right font-bold text-blue-600 text-lg">
                                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Status Pesanan</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Status Pesanan</p>
                                @php
                                    $statusColors = [
                                        'menunggu_penjemputan' => 'bg-yellow-100 text-yellow-700',
                                        'proses' => 'bg-blue-100 text-blue-700',
                                        'selesai' => 'bg-green-100 text-green-700',
                                        'siap_diambil' => 'bg-purple-100 text-purple-700',
                                        'selesai_diambil' => 'bg-gray-100 text-gray-700',
                                        'dibatalkan' => 'bg-red-100 text-red-700',
                                    ];
                                    $colorClass = $statusColors[$order->status_pesanan] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex px-3 py-1.5 rounded-full text-sm font-semibold {{ $colorClass }}">
                                    {{ str_replace('_', ' ', ucfirst($order->status_pesanan)) }}
                                </span>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Status Pembayaran</p>
                                @php
                                    $paymentColors = [
                                        'belum_bayar' => 'bg-red-100 text-red-700',
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'lunas' => 'bg-green-100 text-green-700',
                                    ];
                                    $paymentColor = $paymentColors[$order->status_pembayaran] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex px-3 py-1.5 rounded-full text-sm font-semibold {{ $paymentColor }}">
                                    {{ str_replace('_', ' ', ucfirst($order->status_pembayaran)) }}
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('admin.pesanan.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status Pesanan</label>
                            <select name="status_pesanan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-3 text-sm">
                                <option value="menunggu_penjemputan" {{ $order->status_pesanan == 'menunggu_penjemputan' ? 'selected' : '' }}>Menunggu Penjemputan</option>
                                <option value="proses" {{ $order->status_pesanan == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai" {{ $order->status_pesanan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="siap_diambil" {{ $order->status_pesanan == 'siap_diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                <option value="selesai_diambil" {{ $order->status_pesanan == 'selesai_diambil' ? 'selected' : '' }}>Selesai Diambil</option>
                                <option value="dibatalkan" {{ $order->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition text-sm">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                        
                        @if($order->total_harga == 0 || $order->orderDetails->sum('jumlah') == 0)
                            <a href="{{ route('admin.pesanan.edit-weights', $order) }}" 
                               class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-3 rounded-lg font-medium transition shadow-md flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                                Timbang & Update Berat
                            </a>
                        @else
                            <a href="{{ route('admin.pesanan.edit-weights', $order) }}" 
                               class="w-full bg-white hover:bg-gray-50 text-blue-600 border border-blue-600 px-4 py-3 rounded-lg font-medium transition flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Berat Cucian
                            </a>
                        @endif

                        <button onclick="window.print()" class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg font-medium transition flex items-center justify-center text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Cetak Invoice
                        </button>
                    </div>

                </div>

            </div>
        </main>
    </div>
</div>

</body>
</html>