<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::AllParents()->with('children')->get();
        return view('admin.categories.index' , compact('categories')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'english_name' => 'required|string|max:255',
            'parent_id' => [
                'nullable',
                Rule::exists('categories', 'id')->whereNull('parent_id'),
            ],
            'slug' => 'required|unique:categories,slug',
        ]);

        //insert
        $category = Category::create($validated);

        //json message
        return response()->json($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit' , compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'english_name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $category->update($validated);

          return response()->json([
            'success' => true,
            'message' => 'دسته‌بندی با موفقیت ویرایش شد.',
            'category' => $category
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // dd($category);
        // یا حذف شرطی برای فرزندان
        try {
            $category->delete(); // یا حذف شرطی برای فرزندان
            return response()->json([
                'success' => true,
                'message' => 'دسته‌بندی با موفقیت حذف شد.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف دسته‌بندی.'
            ], 500);
        }
    }
}
