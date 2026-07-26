<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'RantauWallet') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="flex h-screen overflow-hidden">
            
            <!-- SIDEBAR -->
            <aside class="hidden lg:flex lg:flex-col w-64 bg-white border-r border-gray-200">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-100">
                    <a href="/" class="text-xl font-extrabold text-blue-600">💸 RantauWallet</a>
                </div>

                <!-- Menu -->
                <nav class="flex-1 p-4 space-y-1">
                    @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
                        <span class="text-lg">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('transactions.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
                        <span class="text-lg">💳</span>
                        <span>Transaksi</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('categories.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
                        <span class="text-lg">📂</span>
                        <span>Kategori</span>
                    </a>
                    <a href="{{ route('bills.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('bills.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
                        <span class="text-lg">📅</span>
                        <span>Tagihan</span>
                    </a>
                    <a href="{{ route('log.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('log.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
                        <span class="text-lg">📋</span>
                        <span>Log Keuangan</span>
                    </a>

</a>    
                    @endauth
                </nav>

                <!-- User Info -->
                @auth
                <div class="p-4 border-t border-gray-100">
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">Profil</p>
                        </div>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-2 rounded-xl text-red-500 hover:bg-red-50 transition w-full text-sm">
                            <span>🚪</span>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
                @endauth
            </aside>

            <!-- MAIN CONTENT -->
            <div class="flex-1 flex flex-col overflow-hidden">
                
                <!-- Top Bar (Mobile) -->
                <header class="lg:hidden bg-white border-b border-gray-200 p-4 flex items-center justify-between">
                    <a href="/" class="text-xl font-extrabold text-blue-600">💸 RW</a>
                    @auth
                    <a href="{{ route('profile.show') }}" class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </a>
                    @endauth
                </header>

                <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                @if (isset($header))
                    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
                {{ $slot }}
            </main>

        <!-- Mobile Nav Bottom -->
        @auth
        <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50">
            <div class="flex justify-around py-2">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-xs {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400' }} px-3 py-1">
                    <span class="text-xl">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('transactions.index') }}" class="flex flex-col items-center text-xs {{ request()->routeIs('transactions.*') ? 'text-blue-600' : 'text-gray-400' }} px-3 py-1">
                    <span class="text-xl">💳</span>
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex flex-col items-center text-xs {{ request()->routeIs('categories.*') ? 'text-blue-600' : 'text-gray-400' }} px-3 py-1">
                    <span class="text-xl">📂</span>
                    <span>Kategori</span>
                </a>
                <a href="{{ route('profile.show') }}" class="flex flex-col items-center text-xs {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-gray-400' }} px-3 py-1">
                    <span class="text-xl">👤</span>
                    <span>Profil</span>
                </a>
            </div>
        </nav>
        @endauth

    </body>
</html>