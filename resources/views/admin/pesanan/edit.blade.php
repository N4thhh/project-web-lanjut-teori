<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan - Admin LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

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

        <main class="w-full flex-grow p-6 space-y-6">

            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-1">Edit Pesanan</h1>
                    <p class="text-sm text-gray-500">
                        ID Pesanan: <span class="font-mono">#{{ $order->id }}</span>
                    </p>
                </div>
                <a href="{{ route('admin.orders.show', $order) }}"
                   class="text-sm text-gray-600 hover:text-gray-800">
                    &larr; Kembali ke Detail
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg text-sm mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $currentStatus = $order->status ?? 'pending';

                $allowedFlow = [
                    'pending'    => ['pending', 'proses', 'dibatalkan'],
                    'proses'     => ['proses', 'selesai', 'dibatalkan'],
                    'selesai'    => ['selesai', 'diambil'],
                    'diambil'    => ['diambil'],
                    'dibatalkan' => ['dibatalkan'],
                ];

                $allowedNext = $allowedFlow[$currentStatus] ?? ['pending', 'proses', 'dibatalkan'];

                $statusOptions = [
                    'pending'    => 'Pending',
                    'proses'     => 'Proses',
                    'selesai'    => 'Selesai',
                    'diambil'    => 'Diambil',
                    'dibatalkan' => 'Dibatalkan',
                ];
            @endphp

            <form action="{{ route('admin.orders.update', $order) }}" method="POST" onsubmit="return confirmUpdate()">
                @csrf
                @method('PATCH')

                {{-- Status --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
                    <h2 class="text-sm font-semibold text-gray-700 mb-3">Update Status</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500 text-sm">Status Saat Ini:</span>
                        <span class="text-sm font-semibold">
                            {{ ucfirst($currentStatus) }}
                        </span>
                    </div>
                    <div class="mt-3">
                        <label class="block text-sm text-gray-600 mb-1">Status Baru</label>
                        <select name="status"
                                class="text-sm px-3 py-2 border rounded-lg bg-white">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('status', $order->status) == $value ? 'selected' : '' }}
                                    {{ in_array($value, $allowedNext, true) ? '' : 'disabled' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">
                            Status hanya bisa maju sesuai alur sistem, tidak bisa mundur.
                        </p>
                    </div>
                </div>

                {{-- Berat & item --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-800 text-sm">Update Berat & Item Layanan</h2>
                        <p class="text-xs text-gray-500">Sesuaikan berat setelah penimbangan agar total biaya akurat.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Layanan</th>
                                    <th class="px-6 py-3">Keterangan</th>
                                    <th class="px-6 py-3">Berat (kg)</th>
                                    <th class="px-6 py-3">Harga Satuan</th>
                                    <th class="px-6 py-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->orderDetails ?? [] as $detail)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            {{ optional($detail->laundryService)->nama_layanan ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $detail->keterangan ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number"
                                                   step="0.1"
                                                   min="0"
                                                   name="details[{{ $detail->id }}][berat]"
                                                   value="{{ old('details.'.$detail->id.'.berat', $detail->berat) }}"
                                                   class="w-24 px-2 py-1 border rounded text-sm">
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
                                            Tidak ada item layanan pada pesanan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </main>
    </div>
</div>

<script>
function confirmUpdate() {
    return confirm("Yakin ingin menyimpan perubahan status dan berat pesanan ini?");
}
</script>

</body>
</html>
