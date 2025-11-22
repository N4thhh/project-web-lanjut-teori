<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - LaundryKu</title>
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

    @include('includes.header', ['activeMenu' => 'cart'])

    <main class="max-w-4xl mx-auto px-4 py-10 flex-grow w-full">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Keranjang Cucian</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($carts->isEmpty())
            <div class="bg-white p-10 rounded-xl shadow text-center border border-gray-200">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <p class="text-gray-500 mb-4 text-lg">Keranjang Anda masih kosong.</p>
                <a href="{{ route('customer.layanan') }}" class="inline-block bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-hover transition">
                    Pilih Layanan Dulu
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-600">Layanan</th>
                            <th class="px-6 py-4 font-semibold text-gray-600 text-center">Harga / Kg</th>
                            <th class="px-6 py-4 font-semibold text-gray-600 text-center">Jumlah</th>
                            <th class="px-6 py-4 font-semibold text-center text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($carts as $cart)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 text-lg">{{ $cart->service->nama_layanan }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($cart->service->deskripsi, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-50 text-blue-600 py-1 px-3 rounded-full text-sm font-mono">
                                    Rp {{ number_format($cart->service->harga, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full font-bold text-gray-700">
                                    {{ $cart->quantity }}x
                                </div>
                                <div class="text-[10px] text-gray-400 mt-1">Kantong/Pcs</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('customer.cart.destroy', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition flex items-center justify-center mx-auto" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 bg-blue-50 border border-blue-200 p-6 rounded-xl flex flex-col md:flex-row justify-between items-center shadow-sm">
                <div class="mb-4 md:mb-0 md:mr-6">
                    <h3 class="font-bold text-blue-800 text-lg mb-1 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Siap untuk dijemput?
                    </h3>
                    <p class="text-blue-700 text-sm leading-relaxed">
                        Total tagihan akan dihitung akurat setelah kurir kami menimbang cucian Anda. <br>
                        Saat ini tagihan masih tertulis <strong>Rp 0</strong>.
                    </p>
                </div>
                <form action="{{ route('customer.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 py-3 rounded-lg font-bold shadow-lg transition transform hover:scale-105 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Request Penjemputan
                    </button>
                </form>
            </div>
        @endif
    </main>

    @include('includes.footer')
</body>
</html>