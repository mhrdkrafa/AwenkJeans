<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->whereHas('role', function ($q) {
            $q->whereIn('name', ['karyawan', 'kasir', 'owner', 'pelanggan']);
        })->latest()->paginate(15);

        $totalKaryawan = User::whereHas('role', fn($q) => $q->where('name', 'karyawan'))->count();
        $totalKasir = User::whereHas('role', fn($q) => $q->where('name', 'kasir'))->count();
        $totalOwner = User::whereHas('role', fn($q) => $q->where('name', 'owner'))->count();
        $totalPelanggan = User::whereHas('role', fn($q) => $q->where('name', 'pelanggan'))->count();

        return view('administrator.users.index', compact('users', 'totalKaryawan', 'totalKasir', 'totalOwner', 'totalPelanggan'));
    }

    public function create()
    {
        $roles = Role::whereIn('name', ['karyawan', 'kasir', 'owner'])->get();
        return view('administrator.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        // Pastikan role yang dipilih hanya karyawan, kasir, atau owner
        $role = Role::find($request->role_id);
        if (!in_array($role->name, ['karyawan', 'kasir', 'owner'])) {
            return back()->with('error', 'Role tidak valid.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('administrator.users.index')->with('success', "Akun {$role->name} berhasil dibuat.");
    }

    public function edit(User $user)
    {
        $roles = Role::whereIn('name', ['karyawan', 'kasir', 'owner'])->get();
        return view('administrator.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        if ($request->filled('password')) {
            // Prevent reusing the same password
            if (Hash::check($request->password, $user->password)) {
                return back()->withErrors([
                    'password' => 'Password baru tidak boleh sama dengan password yang sedang digunakan. Silakan gunakan password yang berbeda.',
                ])->withInput();
            }
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('administrator.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Jangan hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('administrator.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
