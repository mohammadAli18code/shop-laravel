<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // eager load thumbnail
    $query = Product::with('thumbnail');

    // فیلتر بر اساس دسته‌بندی
    if ($request->category) {
        $category = Category::where('slug', $request->category)->firstOrFail();
        if($category->parent_id != null){
            $query->where('category_id', $category->id);
        } else {
            $children_ids = Category::where('parent_id', $category->id)->pluck('id')->toArray();
            $query->whereIn('category_id', $children_ids);
        }
    }

    // فیلتر ویژه
    if ($request->filter === 'special') {
        $query->where('is_special', 1);
    }

    // مرتب‌سازی
    if ($request->sort) {
        switch ($request->sort) {
            case 'max_price':
                $query->orderBy('price', 'desc');
                break;
            case 'min_price':
                $query->orderBy('price', 'asc');
                break;
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'most_sold':
                $query->orderBy('sold_count', 'desc');
                break;
        }
    }

    // اجرای query
    $products = $query->get();
    $products_count = $products->count();
    $colors = Color::all();

    return view('app.products.index', compact('products', 'colors', 'products_count'));
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
    public function store(StoreProductRequest $request)
    {
        dd('hi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
    
        $product->load(['thumbnail', 'images', 'attributeValues', 'colors' , 'category' , 'cartForCurrentUser' , 'discounts' ,'comments.user'])->loadCount('comments');

        return view('app.products.show' , compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
