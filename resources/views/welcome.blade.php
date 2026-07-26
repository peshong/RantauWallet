<x-guest-layout>
    <x-slot name="header">
        {{-- Kosong --}}
    </x-slot>

    <div class="-mt-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50">
            <div class="max-w-7xl mx-auto px-4 py-24 sm:py-32">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Teks Kiri -->
                    <div>
                        <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-6">
                            🎓 #DariPerantauUntukPerantau
                        </div>
                        <h1 class="text-5xl sm:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                            Atur Duit <span class="text-blue-600">Anti Boncos</span>
                        </h1>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Catat pemasukan, pantau pengeluaran, prediksi saldo, dan wujudkan target tabunganmu. 
                            Didesain khusus buat mahasiswa rantau kayak kita.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            @guest
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                                    🚀 Mulai Gratis
                                </a>
                                <a href="{{ route('login') }}" class="bg-white text-blue-600 px-8 py-4 rounded-xl text-lg font-semibold border-2 border-blue-600 hover:bg-blue-50 transition">
                                    Masuk
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                                    📊 Ke Dashboard
                                </a>
                            @endguest
                        </div>
                        
                        <!-- Stats Mini -->
                        <div class="flex gap-8 mt-10">
                            <div>
                                <p class="text-3xl font-bold text-gray-900">5+</p>
                                <p class="text-gray-500 text-sm">Fitur Utama</p>
                            </div>
                            <div>
                                <p class="text-3xl font-bold text-gray-900">0₫</p>
                                <p class="text-gray-500 text-sm">Gratis Selamanya</p>
                            </div>
                            <div>
                                <p class="text-3xl font-bold text-gray-900">🛡️</p>
                                <p class="text-gray-500 text-sm">Data Aman</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ilustrasi Kanan -->
                    <div class="hidden lg:flex justify-center">
                        <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
                            <!-- Mock Dashboard -->
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">💰</div>
                                <div>
                                    <p class="font-bold text-gray-800">Saldo Kamu</p>
                                    <p class="text-2xl font-extrabold text-green-600">Rp 2.450.000</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                                    <span>🍔 Makan</span>
                                    <span class="text-red-500">-Rp 25.000</span>
                                </div>
                                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                                    <span>🏠 Kos</span>
                                    <span class="text-red-500">-Rp 800.000</span>
                                </div>
                                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                                    <span>💰 Kiriman Ortu</span>
                                    <span class="text-green-500">+Rp 2.000.000</span>
                                </div>
                                <div class="flex justify-between items-center bg-blue-50 p-3 rounded-lg border border-blue-200">
                                    <span class="font-semibold text-blue-600">🎯 Nabung</span>
                                    <span class="text-blue-600 font-bold">Rp 500.000</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Fitur Section -->
        <div id="fitur" class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Fitur Andalan</h2>
                    <p class="text-gray-500 text-lg">Semua yang lo butuhin buat atur keuangan sebagai anak rantau</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-gradient-to-b from-blue-50 to-white p-8 rounded-2xl border border-blue-100 hover:shadow-xl transition">
                        <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center text-2xl mb-5">📊</div>
                        <h3 class="text-xl font-bold mb-3">Catat Transaksi</h3>
                        <p class="text-gray-600">Track pemasukan & pengeluaran harian. Tau persis kemana aja duit lo pergi.</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-gradient-to-b from-green-50 to-white p-8 rounded-2xl border border-green-100 hover:shadow-xl transition">
                        <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center text-2xl mb-5">🎯</div>
                        <h3 class="text-xl font-bold mb-3">Budget & Nabung</h3>
                        <p class="text-gray-600">Atur batas pengeluaran + target nabung. Ada progress bar-nya!</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-gradient-to-b from-purple-50 to-white p-8 rounded-2xl border border-purple-100 hover:shadow-xl transition">
                        <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center text-2xl mb-5">🔮</div>
                        <h3 class="text-xl font-bold mb-3">Prediksi Saldo</h3>
                        <p class="text-gray-600">Sistem kasih tau kapan saldo lo habis. Biar bisa antisipasi dari jauh-jauh hari.</p>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-gradient-to-b from-orange-50 to-white p-8 rounded-2xl border border-orange-100 hover:shadow-xl transition">
                        <div class="w-14 h-14 bg-orange-500 rounded-xl flex items-center justify-center text-2xl mb-5">📋</div>
                        <h3 class="text-xl font-bold mb-3">Tagihan</h3>
                        <p class="text-gray-600">Catat tagihan kos, wifi, listrik. Dapet pengingat sebelum jatuh tempo.</p>
                    </div>

                    <!-- Card 5 -->
                    <div class="bg-gradient-to-b from-red-50 to-white p-8 rounded-2xl border border-red-100 hover:shadow-xl transition">
                        <div class="w-14 h-14 bg-red-500 rounded-xl flex items-center justify-center text-2xl mb-5">🔍</div>
                        <h3 class="text-xl font-bold mb-3">Analisis Bocor</h3>
                        <p class="text-gray-600">Deteksi kategori pengeluaran paling boros. Biar tau mana yang harus dihemat.</p>
                    </div>

                    <!-- Card 6 -->
                    <div class="bg-gradient-to-b from-teal-50 to-white p-8 rounded-2xl border border-teal-100 hover:shadow-xl transition">
                        <div class="w-14 h-14 bg-teal-500 rounded-xl flex items-center justify-center text-2xl mb-5">📱</div>
                        <h3 class="text-xl font-bold mb-3">Responsive</h3>
                        <p class="text-gray-600">Bisa diakses dari HP atau laptop. Catat transaksi kapan aja, dimana aja.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-20">
            <div class="max-w-4xl mx-auto text-center px-4">
                <h2 class="text-4xl font-extrabold text-white mb-4">Siap Atur Keuangan Lo?</h2>
                <p class="text-blue-100 text-lg mb-8">Gabung sekarang, gratis. Dibuat anak rantau, buat anak rantau.</p>
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-10 py-4 rounded-xl text-lg font-bold hover:bg-blue-50 transition shadow-xl">
                        🚀 Daftar Sekarang
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-10 py-4 rounded-xl text-lg font-bold hover:bg-blue-50 transition shadow-xl">
                        📊 Dashboard
                    </a>
                @endguest
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-400 py-10 text-center">
            <p class="text-lg font-bold text-white mb-2">💸 RantauWallet</p>
            <p class="text-sm">Made with ❤️ by mahasiswa perantau • UAS Teknik Informatika • Universitas Malikussaleh</p>
        </footer>
    </div>
</x-guest-layout>