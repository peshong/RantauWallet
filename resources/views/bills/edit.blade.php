<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-sm border p-6">
                <form action="{{ route('bills.update', $bill->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nama</label>
                        <input type="text" name="name" value="{{ $bill->name }}" class="w-full px-4 py-3 border rounded-xl" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Jumlah</label>
                        <input type="number" name="amount" value="{{ $bill->amount }}" class="w-full px-4 py-3 border rounded-xl" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Jatuh Tempo</label>
                        <input type="date" name="due_date" value="{{ $bill->due_date }}" class="w-full px-4 py-3 border rounded-xl" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-3 border rounded-xl" required>
                            <option value="belum_lunas" {{ $bill->status == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="lunas" {{ $bill->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-yellow-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-yellow-600">✏️ Update</button>
                        <a href="{{ route('bills.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>