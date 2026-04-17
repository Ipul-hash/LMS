<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
   
    public function index(Request $request)
    {
        $query = Role::withCount('users')->with('permissions')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $roles       = $query->paginate(10)->withQueryString();
        $permissions = Permission::orderBy('name')->get();

        return view('admin.manajemenrole', compact('roles', 'permissions'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role = Role::create([
            'name'       => strtolower($validated['name']),
            'guard_name' => 'web',
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Role '{$role->name}' berhasil ditambahkan.",
                'role' => $role->load('permissions'),
            ], 201);
        }

        return redirect()->route('manajemenRole')
            ->with('success', "Role '{$role->name}' berhasil ditambahkan.");
    }

 
    public function show(Role $role)
    {
        return response()->json([
            'role'        => $role->only('id', 'name'),
            'permissions' => $role->permissions->pluck('name'),
        ]);
    }

    
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'admin' && $request->name !== 'admin') {
            return redirect()->route('manajemenRole')
                ->with('error', "Nama role 'admin' tidak dapat diubah.");
        }

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:100', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role->update(['name' => strtolower($validated['name'])]);
        $role->syncPermissions($validated['permissions'] ?? []);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Role '{$role->name}' berhasil diperbarui.",
                'role' => $role->load('permissions'),
            ], 200);
        }

        return redirect()->route('manajemenRole')
            ->with('success', "Role '{$role->name}' berhasil diperbarui.");
    }

   
    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('manajemenRole')
                ->with('error', "Role 'admin' tidak dapat dihapus.");
        }

        $userCount = $role->users()->count();
        if ($userCount > 0) {
            return redirect()->route('manajemenRole')
                ->with('error', "Role '{$role->name}' masih digunakan oleh {$userCount} user, tidak dapat dihapus.");
        }

        $name = $role->name;
        $role->syncPermissions([]);
        $role->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Role '{$name}' berhasil dihapus.",
            ], 200);
        }

        return redirect()->route('manajemenRole')
            ->with('success', "Role '{$name}' berhasil dihapus.");
    }
}