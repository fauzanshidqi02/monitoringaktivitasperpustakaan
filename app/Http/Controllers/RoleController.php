<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')
            ->orderBy('name')
            ->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:roles,slug'],
            'description' => ['nullable', 'string'],
        ]);

        $slug = $validated['slug'] ?? Str::of($validated['name'])->slug('_');

        Role::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    public function show(Role $role)
    {
        return redirect()->route('roles.edit', $role);
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'slug')->ignore($role->id),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $role->update([
            'name' => $validated['name'],
            'slug' => Str::of($validated['slug'])->slug('_'),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return redirect()
                ->route('roles.index')
                ->with('error', 'Role tidak bisa dihapus karena masih digunakan oleh user.');
        }

        $protectedRoles = [
            'super_admin',
            'admin',
            'kepala_perpustakaan',
            'koordinator',
            'staf',
            'viewer',
        ];

        if (in_array($role->slug, $protectedRoles)) {
            return redirect()
                ->route('roles.index')
                ->with('error', 'Role bawaan sistem tidak boleh dihapus.');
        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
