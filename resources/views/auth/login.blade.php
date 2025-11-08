<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #dbeafe 100%);
        }
    </style>
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

<body class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-xl">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/Logo.png') }}" alt="LaundryKu Logo" class="w-16 h-16">
            </div>
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">LaundryKu</h1>
                <p class="text-gray-600 text-sm">Masuk ke akun Anda untuk memesan layanan laundry</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <div>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="text-sm">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror"
                            placeholder="Masukkan email Anda" required autofocus>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password"
                            class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password Anda" required>
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="toggleIcon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-hover transition-colors shadow-md">
                    Masuk
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-primary hover:text-primary-hover font-semibold">
                        Daftar di sini
                    </a>
                </p>
            </div>
            
            <div class="text-center mt-4">
                <a href="#" class="text-sm text-gray-500 hover:text-gray-700">
                    Lupa password?
                </a>
            </div>

            <div class="text-center mt-6 pt-6 border-t border-gray-200">
                <a href="{{ url('/') }}"
                    class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>