<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inventory') | Gapol Inventory</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-slate-800 min-h-screen">
    <header class="bg-white shadow-sm">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('inventory') }}" class="font-bold text-lg">📦 Gapol Inventory</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-slate-500 hover:text-red-600">Log out</button>
            </form>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-6">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-800 px-4 py-2">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 text-red-800 px-4 py-2">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>