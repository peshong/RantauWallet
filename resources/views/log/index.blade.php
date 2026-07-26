<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Keuangan') }}
        </h2>
        <button onclick="document.getElementById('reportModal').classList.remove('hidden')"
           class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition shadow">
            🖨️ Cetak Laporan
        </button>
    </div>
</x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kiri: Saldo Cards -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-4">
                        
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-5 text-white shadow-xl">
                            <p class="text-blue-100 text-xs mb-1">Total Uang</p>
                            <h2 class="text-3xl font-extrabold">Rp {{ number_format($saldoTotal, 0, ',', '.') }}</h2>
                        </div>

                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xl">💵</span>
                                <p class="text-sm text-gray-500">Cash</p>
                            </div>
                            <p class="text-2xl font-bold {{ $saldoCash >= 0 ? 'text-gray-900' : 'text-red-600' }}">Rp {{ number_format($saldoCash, 0, ',', '.') }}</p>
                        </div>

                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xl">🏦</span>
                                <p class="text-sm text-gray-500">Rekening</p>
                            </div>
                            <p class="text-2xl font-bold {{ $saldoBank >= 0 ? 'text-gray-900' : 'text-red-600' }}">Rp {{ number_format($saldoBank, 0, ',', '.') }}</p>
                        </div>

                        @if($prediksiTanggalHabis)
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-5 border border-orange-200">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xl">🔮</span>
                                <p class="text-sm font-semibold text-orange-700">Prediksi Saldo</p>
                            </div>
                            <p class="text-xs text-gray-600 mb-1">Saldo diperkirakan habis:</p>
                            <p class="text-lg font-bold text-orange-600">{{ $prediksiTanggalHabis }}</p>
                            <p class="text-xs text-gray-400 mt-2">Rata-rata pengeluaran: <strong>Rp {{ number_format($rataRataHarian, 0, ',', '.') }}</strong>/hari</p>
                        </div>
                        @endif

                        <a href="{{ route('transactions.create') }}" class="flex items-center justify-center gap-2 w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg">
                            ➕ Tambah Transaksi
                        </a>
                    </div>
                </div>

                <!-- Kanan: Log List -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Transaksi</h3>
                    
                    <div class="space-y-6">
                        @forelse($groupedTransactions as $month => $items)
                            <div class="flex items-center gap-3 mb-2">
                                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->isoFormat('MMMM Y') }}
                                </h4>
                                <div class="flex-1 h-px bg-gray-200"></div>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
                                @foreach($items as $trx)
                                    <div x-data="{ open: false }">
                                        <div class="flex items-center justify-between p-4 hover:bg-gray-50 cursor-pointer transition"
                                             @click="open = !open">
                                            
                                            <div class="flex items-center gap-3">
                                                @if($trx->type == 'transfer')
                                                    <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center text-xl">🔄</div>
                                                @else
                                                    <div class="w-11 h-11 {{ $trx->type == 'pemasukan' ? 'bg-green-100' : 'bg-red-100' }} rounded-xl flex items-center justify-center text-xl">
                                                        {{ $trx->category->icon ?? '📌' }}
                                                    </div>
                                                @endif
                                                <div>
                                                    @if($trx->type == 'transfer')
                                                        <p class="font-semibold text-gray-900">
                                                            {{ $trx->source == 'cash' ? '💵' : '🏦' }} → {{ $trx->to_source == 'cash' ? '💵' : '🏦' }}
                                                        </p>
                                                    @else
                                                        <p class="font-semibold text-gray-900">{{ $trx->category->name ?? 'Transfer' }}</p>
                                                    @endif
                                                    <p class="text-xs text-gray-400">
                                                        {{ \Carbon\Carbon::parse($trx->date)->isoFormat('D MMM Y') }}
                                                        · 
                                                        <span class="{{ $trx->source == 'cash' ? 'text-orange-500' : 'text-blue-500' }}">
                                                            {{ $trx->source == 'cash' ? '💵 Cash' : '🏦 Rekening' }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-3">
                                                @if($trx->type == 'transfer')
                                                    <p class="font-bold text-blue-600">~Rp {{ number_format($trx->amount, 0, ',', '.') }}</p>
                                                @else
                                                    <p class="font-bold {{ $trx->type == 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $trx->type == 'pemasukan' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                                    </p>
                                                @endif
                                                <span x-show="!open" class="text-gray-300">▼</span>
                                                <span x-show="open" class="text-gray-300">▲</span>
                                            </div>
                                        </div>

                                        <div x-show="open" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 -translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                                            <div class="grid grid-cols-2 gap-3 text-sm pl-14">
                                                <div>
                                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Tipe</p>
                                                    <p class="font-semibold {{ $trx->type == 'transfer' ? 'text-blue-600' : ($trx->type == 'pemasukan' ? 'text-green-600' : 'text-red-600') }}">
                                                        @if($trx->type == 'transfer')🔄 Transfer
                                                        @elseif($trx->type == 'pemasukan')💰 Pemasukan
                                                        @else💸 Pengeluaran
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Sumber</p>
                                                    <p class="font-semibold">{{ $trx->source == 'cash' ? '💵 Cash' : '🏦 Rekening' }}</p>
                                                </div>
                                                @if($trx->type == 'transfer')
                                                <div>
                                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Tujuan</p>
                                                    <p class="font-semibold">{{ $trx->to_source == 'cash' ? '💵 Cash' : '🏦 Rekening' }}</p>
                                                </div>
                                                @endif
                                                <div class="col-span-2">
                                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Tanggal Lengkap</p>
                                                    <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($trx->date)->isoFormat('dddd, D MMMM Y') }}</p>
                                                </div>
                                                @if($trx->description)
                                                <div class="col-span-2">
                                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Deskripsi</p>
                                                    <p class="font-semibold text-gray-900">{{ $trx->description }}</p>
                                                </div>
                                                @endif
                                                <div class="col-span-2 flex gap-3 pt-2 border-t border-gray-200 mt-2">
                                                    <a href="{{ route('transactions.edit', $trx->id) }}" class="text-xs text-yellow-600 font-medium">✏️ Edit</a>
                                                    <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-500 font-medium" onclick="return confirm('Yakin hapus?')">🗑️ Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
                                <p class="text-5xl mb-4">📭</p>
                                <p class="font-medium">Belum ada transaksi</p>
                                <p class="text-sm">Mulai catat keuanganmu sekarang!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

<!-- Modal Cetak -->
<div id="reportModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">📄 Cetak Laporan</h3>
        
        <form action="{{ route('report.download') }}" method="GET">
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bulan</label>
            <select name="month" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 mb-4" required>
                <option value="">-- Pilih Bulan --</option>
                @php
                    $months = \App\Models\Transaction::where('user_id', Auth::id())
                        ->selectRaw("DATE_FORMAT(date, '%Y-%m') as month")
                        ->groupBy('month')
                        ->orderBy('month', 'desc')
                        ->pluck('month');
                @endphp
                @foreach($months as $m)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::createFromFormat('Y-m', $m)->isoFormat('MMMM Y') }}</option>
                @endforeach
            </select>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition">
                    📥 Download PDF
                </button>
                <button type="button" onclick="document.getElementById('reportModal').classList.add('hidden')"
                    class="flex-1 bg-gray-200 text-gray-700 py-2.5 rounded-xl font-semibold hover:bg-gray-300 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>