<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Customer Panel</title>

    {{-- AKTIFKAN TAILWIND TANPA VITE --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    {{-- HEADER --}}
    @include('includes.header')

    <div class="flex">

        {{-- KONTEN --}}
        <main class="w-full p-6">
            @yield('content')
        </main>

    </div>

    {{-- FOOTER --}}
    @include('includes.footer')

</body>
</html>
