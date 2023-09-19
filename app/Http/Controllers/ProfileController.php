<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Method untuk menampilkan halaman edit profil
    public function edit(User $user)
    {
        if ($user->role->name !== 'superadmin') {
            // Jika bukan superadmin, tidak diizinkan mengedit profil
            return redirect()->route('home')->with('error', 'Access denied.');
        }

        return view('profile.edit', compact('user'));
    }

    // Method untuk menyimpan perubahan profil ke dalam database
    public function update(Request $request, User $user)
    {
        if ($user->role->name !== 'superadmin') {
            // Jika bukan superadmin, tidak diizinkan mengedit profil
            return redirect()->route('home')->with('error', 'Access denied.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        try {
            $data = $request->only(['name', 'username']);

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('home')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangkap exception dan tampilkan pesan error
            return redirect()->route('profile.edit', ['user' => $user->id])->with('error', 'Failed to update profile. Please try again.');
        }
    }
}
