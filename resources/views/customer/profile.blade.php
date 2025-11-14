@extends('includes.layouts.customer-layout')

@section('title', 'Profile Saya')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Profile Saya</h1>

    {{-- Notifikasi sukses --}}
    @if(Session::has('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ Session::get('success') }}
        </div>
    @endif

    {{-- Error validasi --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Informasi Profil --}}
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Informasi Akun</h2>

            <div>
                <dt class="text-gray-500 text-sm">Nama Lengkap</dt>
                <dd class="text-gray-900 font-medium">
                    {{ $user->name ?: ($user->username ?: $user->email) }}
                </dd>
            </div>

            <div>
                <dt class="text-gray-500 text-sm">Email</dt>
                <dd class="text-gray-900 font-medium">{{ $user->email }}</dd>
            </div>

            <div>
                <dt class="text-gray-500 text-sm">No. Telepon</dt>
                <dd class="text-gray-900 font-medium">{{ $user->phone ?? '-' }}</dd>
            </div>

            <div>
                <dt class="text-gray-500 text-sm">Bergabung Pada</dt>
                <dd class="text-gray-900 font-medium">
                    {{ $user->created_at->format('d M Y, H:i') }}
                </dd>
            </div>

            <div>
                <dt class="text-gray-500 text-sm">Terakhir Login</dt>
                <dd class="text-gray-900 font-medium">
                    {{ optional($user->last_login_at ?: $user->updated_at)->format('d M Y, H:i') ?? '-' }}
                </dd>
            </div>
        </div>

        {{-- Form Update Profil --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Profil</h2>

            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                        class="w-full p-2 border rounded focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">No. Telepon</label>
                    <input type="text" name="phone" value="{{ $user->phone }}"
                        class="w-full p-2 border rounded focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                        class="w-full p-2 border rounded focus:ring focus:ring-blue-200">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
