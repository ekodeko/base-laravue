<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->orderBy('name')
            ->paginate(10);
            
        return Inertia::render('master/categories/Index', [
            'categories' => [
                'data' => $categories->items(),
                'meta' => [
                    'total' => $categories->total(),
                    'per_page' => $categories->perPage(),
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'path' => $categories->path(),
                ],
                'links' => [
                    'prev' => $categories->previousPageUrl(),
                    'next' => $categories->nextPageUrl(),
                ]
            ]
        ]);
    }

    public function create()
    {
        $parents = Category::orderBy('name')->get();
        return Inertia::render('master/categories/Form', [
            'parents' => $parents,
            'types' => ['income', 'expense']
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:categories,code',
            'name' => 'required',
            'type' => 'required|in:income,expense',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create($validated);

        return redirect('/master/categories')
            ->with('message', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        $parents = Category::where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();
            
        return Inertia::render('master/categories/Form', [
            'category' => $category,
            'parents' => $parents,
            'types' => ['income', 'expense']
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'code' => 'required|unique:categories,code,'.$category->id,
            'name' => 'required',
            'type' => 'required|in:income,expense',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category->update($validated);

        return redirect('/master/categories')
            ->with('message', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect('/master/categories')
            ->with('message', 'Category deleted successfully');
    }
}
