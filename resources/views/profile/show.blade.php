<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    
                    <!-- Avatar + Nama -->
                    <div class="flex items-center gap-6 mb-8">
                        <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-3xl">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-gray-500">{{ $user->role == 'admin' ? 'Admin' : 'Mahasiswa' }}</p>
                        </div>
                    </div>

                    <!-- Info Detail -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <p class="text-lg font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Nomor HP</label>
                            <p class="text-lg font-medium">{{ $user->nomor_hp ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Kota Asal</label>
                            <p class="text-lg font-medium">{{ $user->kota_asal ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Kota Rantau</label>
                            <p class="text-lg font-medium">{{ $user->kota_rantau ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex gap-3 border-t pt-6">
                        <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                            ✏️ Edit Profil
                        </a>
                        <a href="{{ route('profile.password') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                            🔒 Ganti Password
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>