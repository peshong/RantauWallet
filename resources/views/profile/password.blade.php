<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ganti Password') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Password Saat Ini</label>
                            <input type="password" name="current_password" class="border rounded w-full px-3 py-2" required>
                            @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Password Baru</label>
                            <input type="password" name="password" class="border rounded w-full px-3 py-2" required>
                            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="border rounded w-full px-3 py-2" required>
                        </div>

                        <div class="flex gap-3 border-t pt-6">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">🔒 Ganti Password</button>
                            <a href="{{ route('profile.show') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>