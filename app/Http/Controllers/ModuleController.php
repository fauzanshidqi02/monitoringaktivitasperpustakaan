<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = Module::query()
            ->orderBy('sort_order')
            ->orderBy('name');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $modules = $query->paginate(10)->withQueryString();

        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        return view('modules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:modules,slug'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $validated['slug'] ?? Str::of($validated['name'])->slug('-');

        Module::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('modules.index')
            ->with('success', 'Modul aktivitas berhasil ditambahkan.');
    }

    public function show(Module $module)
    {
        return redirect()->route('modules.edit', $module);
    }

    public function edit(Module $module)
    {
        return view('modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('modules', 'slug')->ignore($module->id),
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $module->update([
            'name' => $validated['name'],
            'slug' => Str::of($validated['slug'])->slug('-'),
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('modules.index')
            ->with('success', 'Modul aktivitas berhasil diperbarui.');
    }

    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()
            ->route('modules.index')
            ->with('success', 'Modul aktivitas berhasil dihapus.');
    }
}
