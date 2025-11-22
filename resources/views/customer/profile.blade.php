<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - LaundryKu</title>
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
    @include('includes.header', ['activeMenu' => 'profil'])

    {{-- Content --}}
    <main class="max-w-4xl mx-auto px-4 py-10 flex-grow w-full">
        
        {{-- Judul --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-gray-500 mt-1">Kelola informasi akun dan data diri Anda.</p>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(Session::has('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 shadow-sm" role="alert">
                <p class="font-bold">Berhasil</p>
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif

        {{-- Error Validasi --}}
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 shadow-sm" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="list-disc list-inside mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- KIRI: Informasi Profil (Read-only) --}}
            <div class="md:col-span-1 space-y-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div class="inline-block p-3 rounded-full bg-primary/10 mb-3">
                        <svg class="h-12 w-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">Customer</p>
                    
                    <div class="mt-6 text-left space-y-3">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Bergabung</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Terakhir Login</p>
                            <p class="text-sm text-gray-700 font-medium">
                                {{ optional($user->last_login_at ?: $user->updated_at)->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KANAN: Form Edit Profil --}}
            <div class="md:col-span-2">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center mb-6 border-b pb-4">
                        <svg class="w-5 h-5 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <h2 class="text-xl font-semibold text-gray-800">Edit Informasi</h2>
                    </div>

                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition outline-none"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </span>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition outline-none"
                                    placeholder="nama@email.com">
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </span>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition outline-none"
                                    placeholder="0812...">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-primary hover:bg-primary-hover text-white px-6 py-2.5 rounded-lg font-medium transition shadow-lg shadow-primary/30 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>

    {{-- Footer --}}
    @include('includes.footer')

</body>
</html>