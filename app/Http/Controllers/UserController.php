<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Hanya admin yang dapat melihat daftar pengguna
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil semua data pengguna dari database
        $users = User::all();

        // Kirim data pengguna ke view
        return view('admin.pages.users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'username' => 'required|min:5',
            'email' => 'required|email',
            'nis_nip' => 'required|min:10',
            'password' => 'required|min:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|in:user,librarian,admin', // Validasi role
        ]);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $photoPath = $file->store('photos', 'public'); // Simpan foto ke folder 'public/photos'
            $validatedData['photo'] = $photoPath;
        }

        // Simpan data user baru
        User::create($validatedData);

        // Redirect atau response setelah menyimpan data
        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Hanya admin yang dapat melihat profil pengguna selain dirinya sendiri
        if (auth()->user()->id !== $id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Tampilkan halaman profil pengguna
        return view('admin.pages.users.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Kirim data pengguna ke view edit
        return view('admin.pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'username' => 'required|min:5',
            'email' => 'required|email',
            'nis_nip' => 'required|min:10',
            'old_password' => 'nullable',
            'new_password' => 'nullable|min:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Cek jika ada input password lama
        if (!empty($request->old_password)) {
            // Verifikasi password lama
            if (Hash::check($request->old_password, $user->password)) {
                // Hash password baru jika diisi
                if (!empty($request->new_password)) {
                    $validatedData['password'] = Hash::make($request->new_password);
                }
            } else {
                return redirect()->back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
            }
        }

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }
            $file = $request->file('photo');
            $photoPath = $file->store('photos', 'public'); // Simpan foto di folder public/photos
            $validatedData['photo'] = $photoPath;
        }

        // Update data pengguna
        $user->update($validatedData);

        // Redirect atau response setelah menyimpan data
        return redirect()->back()->with('success', 'Informasi pengguna berhasil diperbarui!');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy($id)
        {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect to the user list with a success message
        return redirect('/admin/users')->with('success', 'User berhasil dihapus');
    }

}
