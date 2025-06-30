<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        if (! Gate::allows('create-user')) {
            abort(403, 'Anda tidak memiliki izin untuk membuat user baru.');
        }
        // Ini sudah benar: akan mencari resources/views/admin/user_create.blade.php
        return view('admin.user_create');
    }

    public function store(Request $request)
    {
        if (! Gate::allows('create-user')) {
            abort(403, 'Anda tidak memiliki izin untuk membuat user baru.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
            'role' => ['required', 'string', Rule::in(['admin', 'super_admin'])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Redirect setelah sukses, ke daftar user
        return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
    }

    public function index()
    {
        if (! Gate::allows('create-user')) { // Atau gate yang sesuai untuk melihat daftar user
            abort(403, 'Anda tidak memiliki izin untuk melihat daftar user.');
        }

        $users = User::paginate(10);
        // Ini juga sudah benar: akan mencari resources/views/admin/users.blade.php
        return view('admin.users', compact('users'));
    }

    /**
     * Tampilkan form untuk mengedit user tertentu.
     * Menggunakan Implicit Model Binding: Laravel akan menemukan User berdasarkan {user} di URL.
     */
    public function edit(User $user)
    {
        // Memastikan hanya super_admin yang bisa mengakses form edit
        if (! Gate::allows('create-user')) { // Menggunakan Gate 'create-user'
            abort(403, 'Anda tidak memiliki izin untuk mengedit user.');
        }
        return view('admin.user_edit', compact('user')); // Mengarah ke resources/views/admin/user_edit.blade.php
    }

    /**
     * Update user tertentu di database.
     */
    public function update(Request $request, User $user)
    {
        // Memastikan hanya super_admin yang bisa memperbarui user
        if (! Gate::allows('create-user')) { // Menggunakan Gate 'create-user'
            abort(403, 'Anda tidak memiliki izin untuk memperbarui user.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Email unik, kecuali untuk user yang sedang diedit itu sendiri
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // Password opsional saat update: nullable, string, dan harus cocok dengan konfirmasi
            'password' => ['nullable', 'string', 'confirmed'], 
            'role' => ['required', 'string', Rule::in(['admin', 'super_admin'])],
        ]);

        // Update password hanya jika diisi (tidak kosong)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update atribut lainnya
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save(); // Simpan perubahan ke database

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }


     public function destroy(User $user)
    {
        // Memastikan hanya super_admin yang bisa menghapus user
        if (! Gate::allows('create-user')) { // Menggunakan Gate 'create-user'
            abort(403, 'Anda tidak memiliki izin untuk menghapus user.');
        }

        // Pencegahan: Tidak boleh menghapus akun sendiri
        if (auth()->user()->id === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete(); // Hapus user dari database

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}