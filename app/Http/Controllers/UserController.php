<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $query = User::with('roles')->latest();

        if ($request->filled('role')) {
            $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('nim_nip', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $roles  = Role::orderBy('name')->get();

        return view('admin.datapengguna', compact('users', 'roles'));
    }

 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim_nip'  => ['required', 'string', 'max:20', 'unique:users,nim_nip'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', 'exists:roles,name'],
            'is_active'=> ['sometimes', 'boolean'],
        ]);

        $user = User::create([
            'nim_nip'   => $validated['nim_nip'],
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $user->assignRole($validated['role']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "User {$user->name} berhasil ditambahkan.",
                'user' => $user->load('roles'),
            ], 201);
        }

        return redirect()->route('dataPengguna')
            ->with('success', "User {$user->name} berhasil ditambahkan.");
    }

   
    public function show(User $user)
    {
        return response()->json([
            'user' => $user->only('id', 'nim_nip', 'name', 'email', 'is_active'),
            'role' => $user->roles->first()?->name,
        ]);
    }

   
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nim_nip'  => ['required', 'string', 'max:20', Rule::unique('users', 'nim_nip')->ignore($user->id)],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', 'exists:roles,name'],
            'is_active'=> ['sometimes', 'boolean'],
        ]);

        $user->update([
            'nim_nip'   => $validated['nim_nip'],
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'is_active' => $validated['is_active'] ?? $user->is_active,
            ...( $validated['password']
                ? ['password' => Hash::make($validated['password'])]
                : [] ),
        ]);

        $user->syncRoles([$validated['role']]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "User {$user->name} berhasil diperbarui.",
                'user' => $user->load('roles'),
            ], 200);
        }

        return redirect()->route('dataPengguna')
            ->with('success', "User {$user->name} berhasil diperbarui.");
    }

   
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('dataPengguna')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $name = $user->name;
        $user->roles()->detach(); 
        $user->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "User {$name} berhasil dihapus.",
            ], 200);
        }

        return redirect()->route('dataPengguna')
            ->with('success', "User {$name} berhasil dihapus.");
    }

    
    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'Tidak dapat mengubah status akun sendiri.'], 403);
        }

        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'success'   => true,
            'is_active' => $user->is_active,
            'label'     => $user->is_active ? 'Aktif' : 'Nonaktif',
        ]);
    }
}