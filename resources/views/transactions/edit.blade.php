<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8">
                    
                    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" x-data="{ 
                        source: '{{ $transaction->source }}',
                        type: '{{ $transaction->type }}',
                        categories: {
                            @foreach($categories as $cat)
                                '{{ $cat->id }}': '{{ $cat->type }}',
                            @endforeach
                        },
                        updateType(categoryId) {
                            this.type = this.categories[categoryId] || 'pengeluaran';
                        }
                    }">
                        @csrf @method('PUT')
                        <input type="hidden" name="type" x-model="type">

                        <div class="mb-5">
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Sumber Dana</label>
    <div class="grid grid-cols-2 gap-3">
        <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer {{ $transaction->source == 'cash' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }} hover:border-blue-500 transition"
               x-on:click="source = 'cash'">
            <input type="radio" name="source" value="cash" x-model="source" class="hidden">
            <span class="text-2xl">💵</span>
            <div>
                <p class="font-semibold text-gray-900">Cash</p>
                <p class="text-xs text-gray-400">Uang fisik di dompet</p>
            </div>
        </label>
        <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer {{ $transaction->source == 'bank' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }} hover:border-blue-500 transition"
               x-on:click="source = 'bank'">
            <input type="radio" name="source" value="bank" x-model="source" class="hidden">
            <span class="text-2xl">🏦</span>
            <div>
                <p class="font-semibold text-gray-900">Rekening</p>
                <p class="text-xs text-gray-400">Bank / E-Wallet</p>
            </div>
        </label>
    </div>
</div>

                        <div class="mb-5 p-4 bg-gray-50 rounded-xl flex items-center gap-3">
                            <span class="text-sm text-gray-500">Tipe:</span>
                            <span x-show="type === 'pemasukan'" class="px-3 py-1 bg-green-100 text-green-700 rounded-lg font-medium text-sm">💰 Pemasukan</span>
                            <span x-show="type === 'pengeluaran'" class="px-3 py-1 bg-red-100 text-red-700 rounded-lg font-medium text-sm">💸 Pengeluaran</span>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah (Rp)</label>
                            <input type="number" name="amount" value="{{ $transaction->amount }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                            <input type="text" name="description" value="{{ $transaction->description }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                            <input type="date" name="date" value="{{ $transaction->date }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-yellow-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-yellow-600 transition shadow-lg">✏️ Update</button>
                            <a href="{{ route('transactions.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>