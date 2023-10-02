<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{   
    // menampilkan halaman registrasi
    public function index() {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register',
        ]);
    }

    // menyimpan data pendaftaran pengguna 
    public function store(Request $request) {
        // validasi data yang diterima dari formulir registrasi
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        // hashing password sebelum menyimpannya dalam database
        $validatedData['password'] = Hash::make($validatedData['password']);

        // membuat pengguna baru dalam database
        User::create($validatedData);

        // mengatur pesan sukses dalam flash session
        $request = session();
        $request->flash('success', 'Registration successfull! please login');

        // mengarahkan pengguna ke halaman login 
        return redirect('/login');
    }
}
