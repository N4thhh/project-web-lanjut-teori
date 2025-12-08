<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan - Admin</title>
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
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Layanan Baru</h1>

                    <form action="{{ route('admin.layanan.store') }}" method="POST">
                        @csrf

                        <div class="mb-5">
                            <label for="nama_layanan" class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan</label>
                            <input type="text" name="nama_layanan" id="nama_layanan" required
                                class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Cuci Kering">
                        </div>

                        <div class="mb-5">
                            <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">Harga per Kg (Rp)</label>
                            <input type="number" name="harga" id="harga" required min="0"
                                class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: 8000">
                        </div>

                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3"
                                class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Jelaskan detail layanan..."></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 rounded-lg text-white bg-blue-600 hover:bg-blue-700 font-medium transition-colors shadow-lg shadow-blue-600/30 w-full sm:w-auto">
                                Simpan Layanan
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>