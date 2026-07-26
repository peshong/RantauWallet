<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium mb-1">Nama</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border rounded w-full px-3 py-2" required>
                                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border rounded w-full px-3 py-2" required>
                                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Nomor HP</label>
                                <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp) }}" class="border rounded w-full px-3 py-2" placeholder="0812xxxxx">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Kota Asal</label>
                                <input type="text" name="kota_asal" value="{{ old('kota_asal', $user->kota_asal) }}" class="border rounded w-full px-3 py-2" placeholder="Medan, Jakarta, dll">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Kota Rantau</label>
                                <input type="text" name="kota_rantau" value="{{ old('kota_rantau', $user->kota_rantau) }}" class="border rounded w-full px-3 py-2" placeholder="Malang, Bandung, dll">
                            </div>
                        </div>

                        <div class="flex gap-3 border-t pt-6">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">💾 Simpan</button>
                            <a href="{{ route('profile.show') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>