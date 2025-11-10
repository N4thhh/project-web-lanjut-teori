<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Layanan - LaundryKu</title>
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
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- Header --}}
    @include('includes.header', ['activeMenu' => 'layanan'])

    {{-- Content --}}
    <main class="max-w-7xl mx-auto px-4 py-10 flex-grow w-full">
        
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Daftar Layanan Laundry</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Pilih layanan laundry yang sesuai dengan kebutuhan Anda. Semua layanan menggunakan deterjen berkualitas tinggi dan dikerjakan oleh tenaga ahli berpengalaman.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            {{-- Loop data layanan dari controller --}}
            @if($services->isEmpty())
                <p class="text-gray-500 col-span-3 text-center">Belum ada layanan yang tersedia saat ini.</p>
            @else
                @foreach($services as $service)
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between border border-gray-200 hover:border-primary transition-all duration-300">
                    <div>
                        <div class="flex items-center space-x-3 mb-3">
                            {{-- Anda bisa menambahkan kolom icon di database, atau gunakan if/else di sini --}}
                            <span class="flex items-center justify-center h-12 w-12 bg-primary/10 rounded-xl">
                                {{-- Icon Default --}}
                                <svg class="h-6 w-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h7.5m3-15H5.25a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H12M12 6c0-1.72 1.007-3.22 2.5-3.88.5-.25 1-.41 1.5-.54M12 6c-1.72 0-3.218.57-4.5 1.57-.4.32-.75.7-1 1.12" />
                                </svg>
                            </span>
                            <h3 class="text-xl font-semibold text-gray-800">{{ $service->nama_layanan }}</h3>
                        </div>
                        <p class="text-sm text-gray-600 mb-4 min-h-[40px]">{{ $service->deskripsi }}</p>
                    </div>
                    
                    <div class="flex items-center justify-between mt-4">
                        <div class="text-xl font-bold text-primary">
                            Rp {{ number_format($service->harga, 0, ',', '.') }}
                            <span class="text-sm font-normal text-gray-500">/kg</span>
                        </div>
                        <a href="#" class="bg-primary text-white font-semibold px-5 py-2 rounded-lg hover:bg-primary-hover transition-colors">
                            + Tambah
                        </a>
                    </div>
                </div>
                @endforeach
            @endif

        </div>

    </main>

    {{-- Footer --}}
    @include('includes.footer')

</body>
</html>