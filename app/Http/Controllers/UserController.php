<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /** LIST USER */
    public function index(Request $request)
    {
        $searchableColumns = ['name', 'email'];

        $query = User::query();

        // Filter role (optional)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search
        $users = $query->search($request, $searchableColumns)
                       ->latest()
                       ->paginate(10)
                       ->withQueryString();

        return view('admin.user.index', compact('users'));
    }

    /** FORM CREATE USER */
    public function create()
    {
        return view('admin.user.create');
    }

    /** SIMPAN USER BARU */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:SuperAdmin,Admin,User',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('user.index')
                         ->with('success', 'Penambahan Data Berhasil!');
    }

    /** TAMPILKAN DETAIL USER */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    /** FORM EDIT USER */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /** UPDATE USER */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role'     => 'required|in:SuperAdmin,Admin,User',
        ]);

        $user = User::findOrFail($id);

        // Update data dasar
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role']; // FIXED ROLE HERE

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Upload foto baru
        if ($request->hasFile('profile_picture')) {

            // Hapus foto lama jika ada
            if ($user->profile_picture && \Storage::disk('public')->exists($user->profile_picture)) {
                \Storage::disk('public')->delete($user->profile_picture);
            }

            // Upload foto baru
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'Data berhasil diupdate!');
    }

    /** HAPUS USER */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Hapus foto jika ada
        if ($user->profile_picture && \Storage::disk('public')->exists($user->profile_picture)) {
            \Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus!');
    }
}
