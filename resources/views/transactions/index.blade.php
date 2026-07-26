<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('transactions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Transaksi</a>

                    <table class="w-full border-collapse border border-gray-300 mt-4">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">#</th>
                                <th class="border p-2">Tanggal</th>
                                <th class="border p-2">Kategori</th>
                                <th class="border p-2">Tipe</th>
                                <th class="border p-2">Jumlah</th>
                                <th class="border p-2">Deskripsi</th>
                                <th class="border p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $trx)
                            <tr>
                                <td class="border p-2">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $trx->date }}</td>
                                <td class="border p-2">
                                    @if($trx->type == 'transfer')
                                        🔄 Transfer
                                    @else
                                        {{ $trx->category->name ?? '-' }}
                                    @endif
                                </td>
                                <td class="border p-2">
                                    @if($trx->type == 'transfer')
                                        <span class="text-blue-600 font-medium">🔄 Transfer</span>
                                    @elseif($trx->type == 'pemasukan')
                                        <span class="text-green-600 font-medium">💰 Pemasukan</span>
                                    @else
                                        <span class="text-red-600 font-medium">💸 Pengeluaran</span>
                                    @endif
                                </td>
                                <td class="border p-2">
                                    @if($trx->type == 'transfer')
                                        <span class="text-blue-600 font-semibold">~Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                    @elseif($trx->type == 'pemasukan')
                                        <span class="text-green-600 font-semibold">+Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-red-600 font-semibold">-Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                                <td class="border p-2">{{ $trx->description ?? '-' }}</td>
                                <td class="border p-2">
                                    <a href="{{ route('transactions.edit', $trx->id) }}" class="text-yellow-500">Edit</a>
                                    <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>