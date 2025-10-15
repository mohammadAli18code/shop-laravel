<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category.parent')->get();
        // dd($products);
       return view('admin.products.index' , compact(['products' , 'categories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $child_categories = Category::whereNotNull('parent_id')->get();
        $child_categories = Category::allChildren()->get();
        $colors = Color::all();
        return view('admin.products.create' , compact(['child_categories' , 'colors']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->input('attributes'));
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',

            'attributes' => 'required|array',               // خود آرایه
            'attributes.*.name' => 'required|string|max:255', // هر عنصر آرایه
            'attributes.*.value' => 'required|string|max:255',

            'color_ids' => 'required|array',
            'color_ids.*' => 'exists:colors,id',           // هر رنگ باید موجود باشه در جدول colors

            'gallery_images' => 'required|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // هر تصویر
        ]);

        try {
            DB::beginTransaction();
            //product
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $count = 1;

            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $product = Product::create([
                'title' => $validated['title'],
                'slug' => $slug,
                'description' => $validated['description'],
                'stock' => $validated['stock'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
            ]);
            //attributes
            foreach($validated['attributes'] as $attr){
                $product->attributes()->create([
                    'name' => $attr['name'],
                    'value' => $attr['value'],
                ]);
            }
            //images
            foreach($validated['gallery_images'] as $image){
                $filename = uniqid('product_') . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products', $filename, 'public');
                $product->images()->create([
                    'path' => $path,
                ]);
            }
            //colors
            $product->colors()->attach($validated['color_ids']);
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();

            // ثبت خطا در لاگ
            \Log::error('Error creating product: '.$th->getMessage(), [
                'stack' => $th->getTraceAsString()
            ]);

            // پیام امن به کاربر
            return back()->with('error', 'عملیات با خطا مواجه شد. لطفاً دوباره تلاش کنید.');
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->delete()){
            return response()->json(['success' , 'این محصول به شماره با موفقیت حذف شد']);
        }else{
            return response()->json(['error' , 'مشکلی پیش آمد. لطفا دوباره تلاش کنید.']);
        }
    }

    public function toggle(Product $product)
    {
        $product->status = $product->status === 'approved' ? 'pending' : 'approved';
        $product->save();

        return response()->json(['status' => $product->status]);
    }
}
