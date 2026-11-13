<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = User::where('role', 'karyawan')->withCount('diagnosas')->latest()->get();
        return view('karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'karyawan',
            'is_active' => true,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Akun karyawan baru berhasil dibuat.');
    }

    public function edit(User $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, User $karyawan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $karyawan->id,
            'email' => 'required|email|unique:users,email,' . $karyawan->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:6',
        ]);

        $karyawan->name = $validated['name'];
        $karyawan->username = $validated['username'];
        $karyawan->email = $validated['email'];
        $karyawan->phone = $validated['phone'];
        $karyawan->is_active = $validated['is_active'];

        if (!empty($validated['password'])) {
            $karyawan->password = Hash::make($validated['password']);
        }

        $karyawan->save();

        return redirect()->route('karyawan.index')->with('success', 'Data akun karyawan berhasil diperbarui.');
    }

    public function destroy(User $karyawan)
    {
        if ($karyawan->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Akun karyawan berhasil dihapus.');
    }
}

