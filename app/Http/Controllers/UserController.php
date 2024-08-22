<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cek apakah pengguna adalah admin
        if (Auth::user()->role == 'admin') {
            // Tampilkan halaman admin
            $users = User::all();
            return view('admin.pages.users.index', compact('users'));
        } else {
            // Arahkan ke halaman profil pengguna
            return redirect()->route('profile.show', Auth::user()->id);
        }
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
        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Cek apakah pengguna adalah admin
        if (Auth::user()->role == 'admin') {
            // Tampilkan halaman detail pengguna untuk admin
            return view('admin.pages.users.show', compact('user'));
        } elseif (Auth::user()->id == $id) {
            // Tampilkan halaman profil untuk pengguna biasa
            return view('show', compact('user'));
        } else {
            // Jika pengguna biasa mencoba mengakses profil pengguna lain
            return abort(403, 'Unauthorized action.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Cek apakah pengguna adalah admin
        if (Auth::user()->role == 'admin') {
            // Tampilkan halaman edit untuk admin
            return view('admin.pages.users.edit', compact('user'));
        } elseif (Auth::user()->id == $id) {
            // Tampilkan halaman edit profil untuk pengguna biasa
            return view('show', compact('user'));
        } else {
            // Jika pengguna biasa mencoba mengakses halaman edit pengguna lain
            return abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'username' => 'required|min:5',
            'email' => 'required|email',
            'nis_nip' => 'required|min:10',
            'old_password' => 'nullable',
            'new_password' => 'nullable|min:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if old password is provided
        if (!empty($request->old_password)) {
            if (Hash::check($request->old_password, $user->password)) {
                if (!empty($request->new_password)) {
                    $validatedData['password'] = Hash::make($request->new_password);
                }
            } else {
                return redirect()->back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
            }
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }
            $file = $request->file('photo');
            $photoPath = $file->store('photos', 'public');
            $validatedData['photo'] = $photoPath;
        }

        // Update the user data
        $user->update($validatedData);

        // Redirect based on the user's role
        if (Auth::user()->role == 'admin') {
            return redirect()->back()->with('success', 'User updated successfully.');
        } elseif (Auth::user()->id == $id) {
            return redirect()->route('profile.show', $id)->with('success', 'Profile updated successfully.');
        } else {
            return abort(403, 'Unauthorized action.');
        }
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
