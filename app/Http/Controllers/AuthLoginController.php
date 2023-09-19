<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Support\Facades\Session;

class AuthLoginController extends Controller
{
    // Method untuk menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

     // Method untuk menghandle login
     public function login(Request $request)
     {
         // Lakukan validasi input jika diperlukan
         $request->validate([
             'username' => 'required|string',
             'password' => 'required|string',
         ]);
 
         // Coba untuk melakukan login secara manual
         if ($this->attemptLogin($request)) {
             // Jika berhasil, arahkan ke halaman tertentu (misalnya dashboard)
             return redirect()->intended('/home');
         } else {
            // Jika gagal, arahkan kembali ke halaman login dengan pesan error
            Session::flash('error', 'Username or password is incorrect.');
            return redirect()->route('login');
         }
     }
 
     // Metode untuk melakukan login secara manual
     protected function attemptLogin(Request $request)
     {
         // Lakukan proses validasi credentials sesuai dengan kebutuhan Anda
         $username = $request->input('username');
         $password = $request->input('password');
 
         // Lakukan proses otentikasi dengan menggunakan username dan password
         // Perhatikan bahwa kita menggunakan field 'username' sebagai kriteria otentikasi, sesuai dengan kebutuhan Anda.
         if (Auth::attempt(['username' => $username, 'password' => $password])) {
             // Jika credentials valid, lakukan proses login
             // Misalnya, Anda bisa menggunakan Auth facade untuk mengautentikasi user
             return true;
         }
 
         return false;
     }

    // Method untuk logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
