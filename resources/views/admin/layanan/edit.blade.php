<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Layanan - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
        @include('includes.sidebar')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <main class="w-full flex-grow p-6">
                
                <a href="{{ route('admin.layanan') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 mb-6">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Layanan
                </a>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl mx-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Edit Layanan</h1>
                        
                        @if($service->is_active)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200">Aktif</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-200">Non-Aktif</span>
                        @endif
                    </div>

                    <form action="{{ route('admin.layanan.update', $service->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-5">
                            <label for="nama_layanan" class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan</label>
                            <input type="text" name="nama_layanan" id="nama_layanan" required
                                value="{{ old('nama_layanan', $service->nama_layanan) }}"
                                class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-5">
                            <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">Harga per Kg (Rp)</label>
                            <input type="number" name="harga" id="harga" required min="0"
                                value="{{ old('harga', $service->harga) }}"
                                class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-5">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3"
                                class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $service->deskripsi) }}</textarea>
                        </div>

                        <div class="mb-8 pt-4 border-t border-gray-100">
                            <h3 class="block text-sm font-medium text-gray-700 mb-3">Status Layanan</h3>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" 
                                    {{ $service->is_active ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-700">Aktifkan Layanan Ini</span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">Jika dimatikan, layanan ini tidak akan muncul di halaman customer.</p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.layanan') }}" class="px-5 py-2.5 rounded-lg text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 font-medium transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 rounded-lg text-white bg-blue-600 hover:bg-blue-700 font-medium transition-colors shadow-lg shadow-blue-600/30">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>