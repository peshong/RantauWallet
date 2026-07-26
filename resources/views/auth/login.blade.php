<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl overflow-hidden grid grid-cols-1 lg:grid-cols-2 min-h-[600px]">
            
            <!-- Kiri: Ilustrasi -->
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-12 flex flex-col justify-center items-center text-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="absolute top-10 left-10 w-40 h-40 bg-white rounded-full"></div>
                    <div class="absolute bottom-10 right-10 w-60 h-60 bg-white rounded-full"></div>
                </div>
                <div class="relative z-10 text-center">
                    <div class="text-7xl mb-6">💸</div>
                    <h2 class="text-3xl font-bold mb-3">RantauWallet</h2>
                    <p class="text-blue-100 leading-relaxed">Pendamping finansial mahasiswa perantau. Atur duit, pantau pengeluaran, wujudkan tabungan.</p>
                </div>
            </div>

            <!-- Kanan: Form -->
            <div class="p-12 flex flex-col justify-center">
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">Selamat Datang 👋</h3>
                    <p class="text-gray-500 mt-1">Masuk ke akun RantauWallet kamu</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">📧</span>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="contoh@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔒</span>
                            <input type="password" name="password" required
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all hover:shadow-lg">
                        Masuk
                    </button>
                </form>

                <p class="text-center text-sm text-gray-500 mt-8">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700">Daftar gratis</a>
                </p>
            </div>

        </div>
    </div>
</x-guest-layout>