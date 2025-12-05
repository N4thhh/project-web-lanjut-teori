<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan - Admin LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">
    @include('includes.sidebar')

    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="px-6 py-3"><span class="font-medium text-gray-700">Admin</span></div>
        </header>

        <main class="w-full flex-grow p-6 space-y-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-1">Edit Pesanan</h1>
                    <p class="text-sm text-gray-500">ID: <span class="font-mono">#{{ substr($order->id, 0, 8) }}</span></p>
                </div>
                <a href="{{ route('admin.orders.show', $order) }}" class="text-sm text-gray-600 hover:text-gray-800">&larr; Kembali</a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg text-sm mb-4">
                    <ul>@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
                </div>
            @endif

            @php
                $currentStatus = $order->status_pesanan ?? 'menunggu_penjemputan';

                // Alur Baru
                $allowedFlow = [
                    'menunggu_penjemputan' => ['menunggu_penjemputan', 'proses_penimbangan', 'dibatalkan'],
                    'proses_penimbangan'   => ['proses_penimbangan', 'menunggu_pembayaran', 'dibatalkan'],
                    'menunggu_pembayaran'  => ['menunggu_pembayaran', 'proses_pencucian', 'dibatalkan'],
                    'proses_pencucian'     => ['proses_pencucian', 'pengiriman', 'selesai', 'dibatalkan'],
                    'pengiriman'           => ['pengiriman', 'selesai'],
                    'selesai'              => ['selesai', 'diambil'],
                    'diambil'              => ['diambil'],
                    'dibatalkan'           => ['dibatalkan'],
                    // Fallback
                    'pending' => ['menunggu_penjemputan', 'proses_penimbangan'],
                    'proses'  => ['proses_penimbangan', 'menunggu_pembayaran'],
                ];

                $allowedNext = $allowedFlow[$currentStatus] ?? [];

                // Opsi Status Baru
                $statusOptions = [
                    'menunggu_penjemputan' => 'Menunggu Penjemputan',
                    'proses_penimbangan'   => 'Proses Penimbangan',
                    'menunggu_pembayaran'  => 'Menunggu Pembayaran',
                    'proses_pencucian'     => 'Proses Pencucian',
                    'pengiriman'           => 'Pengiriman',
                    'selesai'              => 'Selesai',
                    'diambil'              => 'Sudah Diambil',
                    'dibatalkan'           => 'Dibatalkan',
                ];
            @endphp

            <form action="{{ route('admin.orders.update', $order) }}" method="POST" onsubmit="return confirm('Simpan perubahan?')">
                @csrf
                @method('PATCH')

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
                    <h2 class="text-sm font-semibold text-gray-700 mb-3">Update Status</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500 text-sm">Status Saat Ini:</span>
                        <span class="text-sm font-semibold text-blue-600">
                            {{ $statusOptions[$currentStatus] ?? ucfirst($currentStatus) }}
                        </span>
                    </div>
                    <div class="mt-3">
                        <label class="block text-sm text-gray-600 mb-1">Status Baru</label>
                        <select name="status" class="text-sm px-3 py-2 border rounded-lg bg-white w-full max-w-md">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('status', $currentStatus) == $value ? 'selected' : '' }}
                                    {{ in_array($value, $allowedNext, true) ? '' : 'disabled' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Status mengikuti alur sistem.</p>
                    </div>
                </div>

                {{-- Bagian Berat Tetap Sama --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-800 text-sm">Update Berat</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Layanan</th>
                                    <th class="px-6 py-3">Berat (kg)</th>
                                    <th class="px-6 py-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->orderDetails ?? [] as $detail)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ optional($detail->laundryService)->nama_layanan ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <input type="number" step="0.1" min="0"
                                                   name="details[{{ $detail->id }}][berat]"
                                                   value="{{ old('details.'.$detail->id.'.berat', $detail->berat) }}"
                                                   class="w-24 px-2 py-1 border rounded text-sm">
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-6 py-4 text-center">Tidak ada item.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </main>
    </div>
</div>
</body>
</html>