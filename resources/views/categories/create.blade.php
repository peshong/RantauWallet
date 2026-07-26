<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block">Nama Kategori</label>
                            <input type="text" name="name" class="border rounded w-full px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block">Tipe</label>
                            <select name="type" class="border rounded w-full px-3 py-2" required>
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block">Icon (optional)</label>
                            <input type="text" name="icon" class="border rounded w-full px-3 py-2" placeholder="Contoh: 🍔, 💰">
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                        <a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>