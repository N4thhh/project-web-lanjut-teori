<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Konfigurasi Warna Konsisten --}}
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
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 sm:p-10 border border-gray-100">
        
        <div class="text-center mb-8">
            <img src="{{ asset('images/Logo.png') }}" alt="LaundryKu Logo" class="h-16 w-16 mx-auto mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Verifikasi Email</h2>
            <p class="text-gray-500 text-sm mt-2">
                Kami telah mengirimkan 6 digit kode ke email: <br>
                <span class="font-medium text-gray-800">{{ Auth::user()->email }}</span>
            </p>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm shadow-sm flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('verification.verify') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="otp" class="block text-sm font-medium text-gray-700 mb-2 text-center">Masukkan Kode OTP</label>
                <input type="text" name="otp" id="otp" maxlength="6" autofocus
                    class="w-full text-center text-3xl tracking-[0.5em] font-bold py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition outline-none text-gray-700 placeholder-gray-300"
                    placeholder="......" required>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 rounded-xl transition shadow-lg shadow-primary/30 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Verifikasi Akun
            </button>
        </form>

        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-500 mb-3">Salah email atau ingin ganti akun?</p>
            <a href="{{ route('logout') }}" class="text-sm font-medium text-gray-600 hover:text-red-500 transition flex items-center justify-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"></path></svg>
                <span>Logout</span>
            </a>
        </div>
    </div>

</body>
</html>