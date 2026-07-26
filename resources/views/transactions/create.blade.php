<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8">
                    
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-xl mb-6">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('transactions.store') }}" method="POST" 
                          x-data="{ 
                              type: 'pengeluaran',
                              source: 'cash',
                              to_source: 'bank',
                              categories: {
                                  @foreach($categories as $cat)
                                      '{{ $cat->id }}': '{{ $cat->type }}',
                                  @endforeach
                              },
                              updateType(categoryId) {
                                  if (this.type !== 'transfer') {
                                      this.type = this.categories[categoryId] || 'pengeluaran';
                                  }
                              }
                          }">
                        @csrf
                        <input type="hidden" name="type" x-model="type">

                        <!-- Tipe Transaksi -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Transaksi</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="flex flex-col items-center gap-1 p-4 border-2 rounded-xl cursor-pointer transition"
                                       :class="type === 'pengeluaran' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'"
                                       @click="type = 'pengeluaran'">
                                    <span class="text-2xl">💸</span>
                                    <span class="text-xs font-semibold">Pengeluaran</span>
                                </label>
                                <label class="flex flex-col items-center gap-1 p-4 border-2 rounded-xl cursor-pointer transition"
                                       :class="type === 'pemasukan' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300'"
                                       @click="type = 'pemasukan'">
                                    <span class="text-2xl">💰</span>
                                    <span class="text-xs font-semibold">Pemasukan</span>
                                </label>
                                <label class="flex flex-col items-center gap-1 p-4 border-2 rounded-xl cursor-pointer transition"
                                       :class="type === 'transfer' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300'"
                                       @click="type = 'transfer'">
                                    <span class="text-2xl">🔄</span>
                                    <span class="text-xs font-semibold">Transfer</span>
                                </label>
                            </div>
                        </div>

                        <!-- Kategori (non-transfer) -->
                        <div x-show="type !== 'transfer'" class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                            <select name="category_id" x-on:change="updateType($event.target.value)" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->icon ?? '📌' }} {{ $cat->name }} ({{ $cat->type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sumber Dana -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span x-show="type !== 'transfer'">Sumber Dana</span>
                                <span x-show="type === 'transfer'">Dari</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition"
                                       :class="source === 'cash' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300'"
                                       @click="source = 'cash'; if(type === 'transfer' && to_source === 'cash') to_source = 'bank'">
                                    <span class="text-2xl">💵</span>
                                    <div>
                                        <p class="font-semibold">Cash</p>
                                        <p class="text-xs text-gray-400">Uang fisik</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition"
                                       :class="source === 'bank' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300'"
                                       @click="source = 'bank'; if(type === 'transfer' && to_source === 'bank') to_source = 'cash'">
                                    <span class="text-2xl">🏦</span>
                                    <div>
                                        <p class="font-semibold">Rekening</p>
                                        <p class="text-xs text-gray-400">Bank / E-Wallet</p>
                                    </div>
                                </label>
                            </div>
                            <input type="hidden" name="source" x-model="source">
                        </div>

                        <!-- Tujuan (Transfer) -->
                        <div x-show="type === 'transfer'" class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ke</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition"
                                       :class="to_source === 'cash' ? 'border-green-500 bg-green-50' : (source === 'cash' ? 'border-gray-100 bg-gray-100 opacity-50 cursor-not-allowed' : 'border-gray-200 hover:border-gray-300')"
                                       @click="if(source !== 'cash') to_source = 'cash'">
                                    <span class="text-2xl">💵</span>
                                    <div>
                                        <p class="font-semibold">Cash</p>
                                        <p class="text-xs text-gray-400">Uang fisik</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition"
                                       :class="to_source === 'bank' ? 'border-green-500 bg-green-50' : (source === 'bank' ? 'border-gray-100 bg-gray-100 opacity-50 cursor-not-allowed' : 'border-gray-200 hover:border-gray-300')"
                                       @click="if(source !== 'bank') to_source = 'bank'">
                                    <span class="text-2xl">🏦</span>
                                    <div>
                                        <p class="font-semibold">Rekening</p>
                                        <p class="text-xs text-gray-400">Bank / E-Wallet</p>
                                    </div>
                                </label>
                            </div>
                            <input type="hidden" name="to_source" x-model="to_source">
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah (Rp)</label>
                            <input type="number" name="amount" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 transition" required min="0" placeholder="50000">
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                            <input type="text" name="description" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 transition" placeholder="Catatan...">
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                            <input type="date" name="date" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 transition" required value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg">💾 Simpan</button>
                            <a href="{{ route('transactions.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>