<?php

namespace App\Http\Controllers;

use App\Models\ActivityCategory;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ActivityCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityCategory::with('module')
            ->join('modules', 'activity_categories.module_id', '=', 'modules.id')
            ->select('activity_categories.*')
            ->orderBy('modules.sort_order')
            ->orderBy('activity_categories.sort_order')
            ->orderBy('activity_categories.name');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('activity_categories.name', 'like', "%{$search}%")
                    ->orWhere('activity_categories.slug', 'like', "%{$search}%")
                    ->orWhere('activity_categories.description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('module_id')) {
            $query->where('activity_categories.module_id', $request->module_id);
        }

        if ($request->filled('status')) {
            $query->where('activity_categories.is_active', $request->status === 'active');
        }

        $categories = $query->paginate(10)->withQueryString();

        $modules = Module::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('activity-categories.index', compact('categories', 'modules'));
    }

    public function create()
    {
        $modules = Module::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('activity-categories.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => ['required', 'exists:modules,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('activity_categories', 'slug')
                    ->where('module_id', $request->module_id),
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $validated['slug'] ?? Str::of($validated['name'])->slug('-');

        ActivityCategory::create([
            'module_id' => $validated['module_id'],
            'name' => $validated['name'],
            'slug' => Str::of($slug)->slug('-'),
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('activity-categories.index')
            ->with('success', 'Jenis aktivitas berhasil ditambahkan.');
    }

    public function show(ActivityCategory $activityCategory)
    {
        return redirect()->route('activity-categories.edit', $activityCategory);
    }

    public function edit(ActivityCategory $activityCategory)
    {
        $modules = Module::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('activity-categories.edit', compact('activityCategory', 'modules'));
    }

    public function update(Request $request, ActivityCategory $activityCategory)
    {
        $validated = $request->validate([
            'module_id' => ['required', 'exists:modules,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('activity_categories', 'slug')
                    ->where('module_id', $request->module_id)
                    ->ignore($activityCategory->id),
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $activityCategory->update([
            'module_id' => $validated['module_id'],
            'name' => $validated['name'],
            'slug' => Str::of($validated['slug'])->slug('-'),
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('activity-categories.index')
            ->with('success', 'Jenis aktivitas berhasil diperbarui.');
    }

    public function destroy(ActivityCategory $activityCategory)
    {
        $activityCategory->delete();

        return redirect()
            ->route('activity-categories.index')
            ->with('success', 'Jenis aktivitas berhasil dihapus.');
    }
}
