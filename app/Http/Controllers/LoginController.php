<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{   
    // menampilkan halaman login 
    public function index()
    {
        return view('login.index', [
            'title' => 'login',
            'active' => 'login'
        ]);
    }
    
    // mengautentikasi pengguna
    public function authenticate(Request $request)
    {   
        // validasi data yang diterima dari formulir login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // mencoba melakukan autentikasi dengan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil, regenerate session dan redirect ke halaman yang dituju (dashboard)
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Jika autentikasi gagal, kembali ke halaman login dengan pesan error
        return back()->with('loginError', 'Login Failed');
    }

    // logout pengguna
    public function logout(Request $request) {

        // logout pengguna
        Auth::logout();

        // menghapus session pengguna
        $request->session()->invalidate();
        
        // mengenerate token sesi baru 
        $request->session()->regenerateToken();

        // redirect ke halaman utama (login)
        return redirect('/');

    }
}
