<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $allTransactions = \App\Models\Transaction::where('user_id', Auth::id())->get();
        
        $pemasukanAll = $allTransactions->where('type', 'pemasukan')->sum('amount');
        $pengeluaranAll = $allTransactions->where('type', 'pengeluaran')->sum('amount');
        $saldo = $pemasukanAll - $pengeluaranAll;
        
        $transferMasukCash = $allTransactions->where('type', 'transfer')->where('to_source', 'cash')->sum('amount');
        $transferKeluarCash = $allTransactions->where('type', 'transfer')->where('source', 'cash')->sum('amount');
        $transferMasukBank = $allTransactions->where('type', 'transfer')->where('to_source', 'bank')->sum('amount');
        $transferKeluarBank = $allTransactions->where('type', 'transfer')->where('source', 'bank')->sum('amount');
        
        $saldoCash = $allTransactions->where('type', 'pemasukan')->where('source', 'cash')->sum('amount')
                    + $transferMasukCash
                    - $allTransactions->where('type', 'pengeluaran')->where('source', 'cash')->sum('amount')
                    - $transferKeluarCash;
        
        $saldoBank = $allTransactions->where('type', 'pemasukan')->where('source', 'bank')->sum('amount')
                    + $transferMasukBank
                    - $allTransactions->where('type', 'pengeluaran')->where('source', 'bank')->sum('amount')
                    - $transferKeluarBank;
        
        $now = \Carbon\Carbon::now();
        $start = $now->copy()->startOfMonth()->format('Y-m-d');
        $end = $now->copy()->endOfMonth()->format('Y-m-d');
        
        $bulanIni = $allTransactions->whereBetween('date', [$start, $end]);
        $pemasukanBulanIni = $bulanIni->where('type', 'pemasukan')->sum('amount');
        $pengeluaranBulanIni = $bulanIni->where('type', 'pengeluaran')->sum('amount');
        
        $hariIni = $now->day;
        $rataRata = $hariIni > 0 ? $pengeluaranBulanIni / $hariIni : 0;
        
        $recentTransactions = \App\Models\Transaction::where('user_id', Auth::id())
            ->with('category')
            ->latest('date')
            ->latest('created_at')
            ->take(5)
            ->get();
    @endphp

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-gray-500 mt-1">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                <a href="{{ route('transactions.create') }}" class="mt-4 sm:mt-0 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                    + Tambah Transaksi
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Uang -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Total Uang</span>
                        <span class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-xl">💰</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                    <div class="flex gap-4 mt-2 text-xs text-gray-400">
                        <span>💵 Cash: Rp {{ number_format($saldoCash, 0, ',', '.') }}</span>
                        <span>🏦 Bank: Rp {{ number_format($saldoBank, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Pemasukan -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Pemasukan Bulan Ini</span>
                        <span class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-xl">📈</span>
                    </div>
                    <p class="text-2xl font-bold text-green-600">+Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $bulanIni->where('type', 'pemasukan')->count() }} transaksi</p>
                </div>

                <!-- Pengeluaran -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Pengeluaran Bulan Ini</span>
                        <span class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-xl">📉</span>
                    </div>
                    <p class="text-2xl font-bold text-red-600">-Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $bulanIni->where('type', 'pengeluaran')->count() }} transaksi</p>
                </div>

                <!-- Tabungan -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 shadow-sm border border-purple-200">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-purple-700">🐷 Tabungan</span>
                        <span class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-xl">🐷</span>
                    </div>
                    @php
                        $sisaHari = $now->diffInDays($now->copy()->endOfMonth()) + 1;
                        $prediksiPengeluaranSisaBulan = $rataRata * $sisaHari;
                        $prediksiSisaSaldo = $saldo - $prediksiPengeluaranSisaBulan;
                        $persentaseTabungan = $saldo > 0 ? max(0, ($prediksiSisaSaldo / $saldo) * 100) : 0;
                    @endphp
                    @if($prediksiSisaSaldo > 0)
                        <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($prediksiSisaSaldo, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Estimasi sisa saldo akhir bulan</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-3">
                            <div class="bg-purple-500 h-2.5 rounded-full" style="width: {{ round($persentaseTabungan) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">{{ round($persentaseTabungan) }}% dari saldo bisa ditabung</p>
                    @else
                        <p class="text-lg font-bold text-red-600">⚠️ Saldo kurang</p>
                        <p class="text-xs text-gray-500 mt-1">Estimasi pengeluaran melebihi saldo</p>
                    @endif
                </div>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h3>
                    <a href="{{ route('log.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat semua →</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentTransactions as $trx)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                @if($trx->type == 'transfer')
                                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-lg">🔄</div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $trx->source == 'cash' ? '💵' : '🏦' }} → {{ $trx->to_source == 'cash' ? '💵' : '🏦' }}</p>
                                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($trx->date)->isoFormat('D MMM Y') }}</p>
                                    </div>
                                @else
                                    <div class="w-10 h-10 {{ $trx->type == 'pemasukan' ? 'bg-green-100' : 'bg-red-100' }} rounded-xl flex items-center justify-center text-lg">
                                        {{ $trx->category->icon ?? '📌' }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $trx->category->name ?? 'Transfer' }}</p>
                                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($trx->date)->isoFormat('D MMM Y') }} · {{ $trx->source == 'cash' ? '💵 Cash' : '🏦 Rekening' }}</p>
                                    </div>
                                @endif
                            </div>
                            @if($trx->type == 'transfer')
                                <span class="font-semibold text-blue-600">~Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                            @else
                                <span class="font-semibold {{ $trx->type == 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $trx->type == 'pemasukan' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-400 py-8">Belum ada transaksi</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>