<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $user = User::findOrFail($id);
        return view('admin.pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {

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
