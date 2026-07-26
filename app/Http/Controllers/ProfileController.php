<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Tampilkan profil
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    // Form edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update profil
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'nomor_hp' => 'nullable|string|max:15',
            'kota_asal' => 'nullable|string|max:100',
            'kota_rantau' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nomor_hp = $request->nomor_hp;
        $user->kota_asal = $request->kota_asal;
        $user->kota_rantau = $request->kota_rantau;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diupdate!');
    }

    // Form ganti password
    public function editPassword()
    {
        return view('profile.password');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Password berhasil diubah!');
    }
}