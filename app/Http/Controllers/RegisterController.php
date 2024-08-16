<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.register');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'username' => 'required|min:5',
            'email' => 'required|email',
            'nis_nip' => 'required|min:10',
            'password' => 'required|min:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Atur role default
        $validatedData['role'] = 'user'; // Role default untuk pendaftaran

        // Handle file upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $photoPath;
        }

        // Simpan data user baru
        User::create($validatedData);

        // Redirect atau response setelah menyimpan data
        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
