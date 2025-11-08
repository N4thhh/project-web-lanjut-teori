<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LaundryKu - Layanan Laundry Online Terpercaya</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

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
<body class="antialiased bg-white text-gray-800">

    <header class="relative w-full z-10 px-4 sm:px-6 lg:px-8 bg-white shadow-md">
        <nav class="flex items-center justify-between h-16 lg:h-20 max-w-7xl mx-auto">
            
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center space-x-2">
                    <img src="{{ asset('images/Logo.png') }}" alt="LaundryKu Logo" class="h-10 w-10">
                    <span class="text-2xl font-bold text-gray-900">LaundryKu</span>
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-primary border border-primary rounded-lg hover:bg-primary/10 transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-hover transition-colors">
                    Daftar
                </a>
            </div>
        </nav>
    </header>

    <main>
        <div class="relative" style="background-color: #f0f8ff;">
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-24 lg:py-28">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl max-w-2xl">
                    <span class="block xl:inline">Layanan Laundry Online</span>
                    <span class="block text-primary xl:inline">Terpercaya</span>
                </h1>
                <p class="mt-4 max-w-xl text-base text-gray-600 sm:text-lg md:text-xl">
                    Nikmati kemudahan layanan laundry berkualitas tinggi dengan pickup dan delivery gratis. Pakaian bersih, wangi, dan rapi dalam 24 jam.
                </p>
                
                <div class="mt-10 flex items-center space-x-4">
                    <div class="rounded-lg">
                        <a href="{{ route('register') }}" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary hover:bg-primary-hover md:py-4 md:text-lg md:px-10">
                            Daftar
                        </a>
                    </div>
                    <div class="rounded-lg">
                        <a href="{{ route('login') }}" class="flex items-center justify-center px-8 py-3 border border-primary text-base font-medium rounded-lg text-primary bg-white hover:bg-primary/10 md:py-4 md:text-lg md:px-10">
                            Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="py-16 sm:py-24 bg-white">
             <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900">Kategori Layanan</h2>
                <p class="mt-4 text-center text-gray-600">Pilih kategori layanan laundry yang sesuai dengan kebutuhan Anda</p>

                <div class="mt-12 grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div class="flex flex-col items-center p-6 bg-white rounded-xl border border-primary transition-transform hover:scale-105">
                        <span class="text-4xl">👕</span>
                        <h3 class="mt-4 font-semibold text-gray-900">Cuci Kering</h3>
                    </div>
                    <div class="flex flex-col items-center p-6 bg-white rounded-xl border border-primary transition-transform hover:scale-105">
                        <span class="text-4xl">🔥</span>
                        <h3 class="mt-4 font-semibold text-gray-900">Setrika</h3>
                    </div>
                    <div class="flex flex-col items-center p-6 bg-white rounded-xl border border-primary transition-transform hover:scale-105">
                        <span class="text-4xl">👚</span>
                        <h3 class="mt-4 font-semibold text-gray-900">Cuci Lipat</h3>
                    </div>
                    <div class="flex flex-col items-center p-6 bg-white rounded-xl border border-primary transition-transform hover:scale-105">
                        <span class="text-4xl">💧</span>
                        <h3 class="mt-4 font-semibold text-gray-900">Cuci Basah</h3>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 sm:py-24 bg-gray-50 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900">Layanan Unggulan</h2>
                <p class="mt-4 text-center text-gray-600">Layanan terpopuler dengan kualitas terbaik dan harga terjangkau</p>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="bg-white p-6 rounded-xl border border-primary relative">
                        <span class="absolute top-0 right-0 -mt-3 mr-6 px-3 py-1 bg-primary text-white text-sm font-semibold rounded-full">Terpopuler</span>
                        <div class="flex items-center space-x-4">
                            <span class="text-3xl p-3 bg-primary/20 rounded-lg">🧺</span>
                            <h3 class="text-xl font-semibold text-gray-900">Cuci Setrika</h3>
                        </div>
                        <p class="mt-4 text-gray-600">Pakaian dicuci bersih dan disetrika rapi, siap pakai.</p>
                        <div class="flex justify-end items-center mt-6">
                            <span class="text-xl font-bold text-primary">Rp 12.000<span class="text-sm font-normal text-gray-500"> /kg</span></span>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-yellow-500 relative">
                        <span class="absolute top-0 right-0 -mt-3 mr-6 px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-full">Premi</span>
                        <div class="flex items-center space-x-4">
                            <span class="text-3xl p-3 bg-yellow-100 rounded-lg">💧</span>
                            <h3 class="text-xl font-semibold text-gray-900">Cuci Kering</h3>
                        </div>
                        <p class="mt-4 text-gray-600">Pembersihan khusus untuk pakaian berbahan sensitif.</p>
                        <div class="flex justify-end items-center mt-6">
                            <span class="text-xl font-bold text-yellow-600">Rp 25.000<span class="text-sm font-normal text-gray-500"> /kg</span></span>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-green-500 relative">
                        <span class="absolute top-0 right-0 -mt-3 mr-6 px-3 py-1 bg-green-500 text-white text-sm font-semibold rounded-full">Hemat</span>
                        <div class="flex items-center space-x-4">
                            <span class="text-3xl p-3 bg-green-100 rounded-lg">👕</span>
                            <h3 class="text-xl font-semibold text-gray-900">Cuci Kering</h3>
                        </div>
                        <p class="mt-4 text-gray-600">Layanan cuci bersih tanpa setrika, cocok untuk pakaian sehari-hari.</p>
                        <div class="flex justify-end items-center mt-6">
                            <span class="text-xl font-bold text-green-600">Rp 8.000<span class="text-sm font-normal text-gray-500"> /kg</span></span>
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    <a href="{{ route('register') }}" class="px-8 py-3 text-base font-medium text-primary border border-primary rounded-full hover:bg-primary/10 transition-colors">
                        Lihat Semua Layanan &rarr;
                    </a>
                </div>
            </div>
        </section>

        <section class="py-16 sm:py-24 bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900">Mengapa Memilih LaundryKu?</h2>
                <p class="mt-4 text-center text-gray-600">Kami berkomitmen memberikan pelayanan terbaik dengan standar kualitas tinggi</p>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 bg-white rounded-xl border border-primary text-center">
                        <span class="text-4xl">⏱️</span>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Cepat & Tepat Waktu</h3>
                        <p class="mt-2 text-gray-600">Layanan ekspres 24 jam dengan pickup dan delivery gratis di area Jakarta.</p>
                    </div>
                    <div class="p-6 bg-white rounded-xl border border-primary text-center">
                        <span class="text-4xl">🛡️</span>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Kualitas Terjamin</h3>
                        <p class="mt-2 text-gray-600">Menggunakan deterjen berkualitas tinggi dan teknologi mesin modern.</p>
                    </div>
                    <div class="p-6 bg-white rounded-xl border border-primary text-center">
                        <span class="text-4xl">💸</span>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Harga Terjangkau</h3>
                        <p class="mt-2 text-gray-600">Harga kompetitif dengan berbagai promo menarik setiap bulannya.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-primary text-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <div class="md:col-span-1 lg:col-span-2">
                <a href="/" class="flex items-center space-x-2">
                     <img src="{{ asset('images/Logo.png') }}" alt="LaundryKu Logo" class="h-10 w-10">
                    <span class="text-2xl font-bold text-white">LaundryKu</span>
                </a>
                <p class="mt-4 text-sm text-blue-50 max-w-sm">
                    Layanan laundry online terpercaya dengan kualitas terbaik dan harga terjangkau. Kami siap melayani kebutuhan laundry Anda dengan profesional.
                </p>
                <div class="mt-6 flex space-x-4">
                    <a href="#" class="text-blue-50 hover:text-white"><span>Facebook</span></a>
                    <a href="#" class="text-blue-50 hover:text-white"><span>Instagram</span></a>
                    <a href="#" class="text-blue-50 hover:text-white"><span>Twitter</span></a>
                </div>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white">Layanan</h4>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="#" class="text-blue-50 hover:text-white">Cuci Kering</a></li>
                    <li><a href="#" class="text-blue-50 hover:text-white">Cuci Setrika</a></li>
                    <li><a href="#" class-="text-blue-50 hover:text-white">Cuci Lipat</a></li>
                    <li><a href="#" class="text-blue-50 hover:text-white">Cuci Basah</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white">Kontak</h4>
                <ul class="mt-4 space-y-2 text-sm text-blue-50">
                    <li><span>+62 812-3456-7890</span></li>
                    <li><span>info@laundryku.com</span></li>
                    <li><span>Jakarta, Indonesia</span></li>
                </ul>
            </div>
        </div>
        <div class="bg-primary-hover py-4">
            <p class="text-center text-sm text-blue-50">&copy; 2024 LaundryKu. Semua hak dilindungi.</p>
        </div>
    </footer>

</body>
</html>