<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // Method untuk menampilkan halaman daftar user
    public function index(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan pencarian
        $searchKeyword = $request->input('search');
        if ($searchKeyword) {
            $query->where('name', 'like', "%{$searchKeyword}%")
                ->orWhere('username', 'like', "%{$searchKeyword}%")
                ->orWhereHas('role', function ($query) use ($searchKeyword) {
                    $query->where('name', 'like', "%{$searchKeyword}%");
                });
        }

        $query->orderByDesc('created_at');

        // Ambil data dengan pagination
        $users = $query->paginate(5);

        return view('users.index', compact('users', 'searchKeyword'));
    }

    // Method untuk menampilkan halaman form tambah user
    public function create()
    {
        // Ambil semua peran kecuali 'superadmin'
        $roles = Role::where('name', '<>', 'superadmin')->get();

        return view('users.create', compact('roles'));
    }

    // Method untuk menyimpan data user baru ke dalam database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);
    
        try {
            $data = $request->only(['name', 'username', 'password', 'role_id']);
            $data['password'] = Hash::make($data['password']);
    
            User::create($data);
    
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangkap exception dan tampilkan pesan error
            return redirect()->route('users.create')->with('error', 'Failed to create user. Please try again.');
        }
    }

    // Method untuk menampilkan halaman form edit user
    public function edit(User $user)
    {
        if ($user->role->name === 'superadmin') {
            return redirect()->route('users.index')->with('error', 'Superadmin cannot be edited.');
        }
    
        // Ambil semua peran kecuali 'superadmin'
        $roles = Role::where('name', '<>', 'superadmin')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    // Method untuk menyimpan perubahan data user ke dalam database
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);
    
        // Check if the user being updated is 'superadmin'
        if ($user->role->name === 'superadmin') {
            return redirect()->route('users.index')->with('error', 'Superadmin cannot be updated.');
        }
    
        try {
            $data = $request->only(['name', 'username', 'role_id']);
    
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
    
            $user->update($data);
    
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangkap exception dan tampilkan pesan error
            return redirect()->route('users.edit', ['user' => $user->id])->with('error', 'Failed to update user. Please try again.');
        }
    }
    

    // Method untuk menghapus data user dari database
    public function destroy(User $user)
    {
        try {
            // Cek apakah user yang akan dihapus adalah superadmin
            if ($user->role->name === 'superadmin') {
                // Superadmin tidak diizinkan untuk dihapus
                return redirect()->route('users.index')->with('error', 'Superadmin cannot be deleted.');
            }
    
            $user->delete();
    
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangkap exception dan tampilkan pesan error
            return redirect()->route('users.index')->with('error', 'Failed to delete user. Please try again.');
        }
    }
}
