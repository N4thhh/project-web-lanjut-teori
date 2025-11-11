<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LaundryKu — Profil</title>

  {{-- TailwindCSS --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#4FC3F7',   // biru muda
            accent:  '#0288D1',   // biru tua aksen
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

  {{-- Header --}}
  @include('includes.header', ['activeMenu' => 'profile'])

  {{-- Title --}}
  <header class="bg-white/60 backdrop-blur border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-6">
      <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Profil Pengguna</h1>
      <p class="text-gray-600 mt-1">Ringkasan akun & pengaturan sederhana.</p>
    </div>
  </header>

  <main class="max-w-7xl mx-auto px-4 py-10 w-full flex-grow">

    @if (session('success'))
      <div class="mb-6 rounded-xl border border-green-200 bg-green-50 text-green-800 px-4 py-3">
        {{ session('success') }}
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Informasi Akun --}}
      <section class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 lg:col-span-1">
        <h2 class="font-semibold text-gray-900 mb-4">Informasi Akun</h2>
        <dl class="text-sm space-y-3">
          <div class="flex justify-between">
            <dt class="text-gray-600">Nama Lengkap / Username</dt>
            <dd class="text-gray-900 font-medium">{{ $user->name ?? $user->username ?? $user->email }}</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-gray-600">Email</dt>
            <dd class="text-gray-900 font-medium">{{ $user->email ?? '—' }}</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-gray-600">Status Akun</dt>
            <dd>
              @php $ok = ($accountStatus ?? 'aktif') === 'aktif'; @endphp
              <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $ok ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ ucfirst($accountStatus ?? 'aktif') }}
              </span>
            </dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-gray-600">Peran</dt>
            <dd>
              <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                {{ ucfirst($user->role ?? 'customer') }}
              </span>
            </dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-gray-600">Terakhir Masuk</dt>
            <dd class="text-gray-900 font-medium">
              {{ optional($user->last_login_at ?? $user->updated_at)->format('d M Y, H:i') }}
            </dd>
          </div>
        </dl>
      </section>

      {{-- Pengaturan / Edit Profile (Nama & Email saja) --}}
      <section class="bg-white rounded-2xl shadow-lg border border-gray-100 lg:col-span-2">
        <div class="px-6 py-4 border-b border-gray-100">
          <h3 class="font-semibold text-gray-900">Pengaturan Akun</h3>
          <p class="text-sm text-gray-500">Ubah nama & email Anda.</p>
        </div>

        <form method="post" action="{{ route('customer.profile.update') }}" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
          @csrf

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap / Username</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? $user->username ?? '') }}"
                   class="w-full rounded-xl border-gray-300 focus:border-accent focus:ring-accent"/>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email (opsional)</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full rounded-xl border-gray-300 focus:border-accent focus:ring-accent"/>
          </div>

          <div class="md:col-span-2 text-right">
            <a href="{{ route('customer.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200">Batal</a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-accent text-white font-semibold hover:bg-accent/90">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </section>

    </div>
  </main>

  {{-- Footer --}}
  @include('includes.footer')

</body>
</html>
