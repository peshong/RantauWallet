<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-sm border p-6">
                <form action="{{ route('bills.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nama Tagihan</label>
                        <input type="text" name="name" class="w-full px-4 py-3 border rounded-xl" required placeholder="Kos, WiFi, Listrik...">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Jumlah (Rp)</label>
                        <input type="number" name="amount" class="w-full px-4 py-3 border rounded-xl" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-1">Jatuh Tempo</label>
                        <input type="date" name="due_date" class="w-full px-4 py-3 border rounded-xl" required>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700">💾 Simpan</button>
                        <a href="{{ route('bills.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>