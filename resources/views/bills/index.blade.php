<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('📅 Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('bills.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition shadow mb-6 inline-block">
                + Tambah Tagihan
            </a>

            <div class="space-y-4">
                @forelse($bills as $bill)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $bill->name }}</h3>
                                <p class="text-sm text-gray-400">Jatuh tempo: {{ \Carbon\Carbon::parse($bill->due_date)->isoFormat('D MMMM Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($bill->amount, 0, ',', '.') }}</p>
                                @if($bill->status == 'lunas')
                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-medium">✅ Lunas</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-medium">❌ Belum Lunas</span>
                                @endif
                            </div>
                        </div>

                        @php $progress = $bill->amount > 0 ? ($bill->totalPaid() / $bill->amount) * 100 : 0; @endphp
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Terbayar: Rp {{ number_format($bill->totalPaid(), 0, ',', '.') }} ({{ round($progress) }}%)</p>

                        <div class="flex gap-2 mt-4">
                            @if($bill->status == 'belum_lunas')
                                <button onclick="document.getElementById('payModal{{ $bill->id }}').classList.remove('hidden')"
                                    class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-green-700 transition">
                                    💰 Bayar
                                </button>
                                <form action="{{ route('bills.remind', $bill->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-blue-600 transition">
                                        📧 Reminder
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('bills.edit', $bill->id) }}" class="bg-yellow-500 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-yellow-600 transition">✏️ Edit</a>
                            <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-red-600 transition" onclick="return confirm('Yakin hapus?')">🗑️ Hapus</button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Bayar -->
                    <div id="payModal{{ $bill->id }}" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">💰 Bayar: {{ $bill->name }}</h3>
                            <p class="text-sm text-gray-500 mb-2">Sisa: Rp {{ number_format($bill->remaining(), 0, ',', '.') }}</p>
                            <form action="{{ route('bills.pay', $bill->id) }}" method="POST">
                                @csrf
                                <input type="number" name="amount" class="w-full px-4 py-3 border rounded-xl mb-3" placeholder="Jumlah bayar" required max="{{ $bill->remaining() }}">
                                <input type="date" name="paid_at" class="w-full px-4 py-3 border rounded-xl mb-4" value="{{ date('Y-m-d') }}">
                                <div class="flex gap-2">
                                    <button type="submit" class="flex-1 bg-green-600 text-white py-2.5 rounded-xl font-semibold hover:bg-green-700">Bayar</button>
                                    <button type="button" onclick="document.getElementById('payModal{{ $bill->id }}').classList.add('hidden')" class="flex-1 bg-gray-200 py-2.5 rounded-xl">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-12 text-center text-gray-400">
                        <p class="text-5xl mb-4">📭</p>
                        <p>Belum ada tagihan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>