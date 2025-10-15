<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index' , compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            $file = $request->file('image');
            $filename = uniqid('banner_') . '.' . $file->getClientOriginalExtension();
            $destination = public_path('images/banners');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename); // save image file 
            $validated['image'] = 'images/banners/' . $filename;

            //store
            Banner::create($validated);

            return redirect()->route('admin.banners.index')->with('success' , 'بنر با موفقیت ایجاد شد');

        } catch (\Exception $e) {
            if (isset($validated['image']) && file_exists(public_path($validated['image']))) {
                unlink(public_path($validated['image']));
            }
            return redirect()->back()->with('error', 'مشکلی پیش آمد. لطفا دوباره تلاش کنید.');
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
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit' , compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            if ($request->hasFile('image')){
                if ($banner->image && File::exists(public_path($banner->image))) {
                    File::delete(public_path($banner->image));
                }
                $file = $request->file('image');
                $filename = uniqid('banner_') . '.' . $file->getClientOriginalExtension();
                $destination = public_path('images/banners');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
                $file->move($destination, $filename); // save image file 
                $validated['image'] = 'images/banners/' . $filename;
            }

            $banner->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'این بنر با موفقیت ویرایش شد',
            ]);
        } catch (\Exception $e) {

            if (isset($validated['image']) && file_exists(public_path($validated['image']))) {
                unlink(public_path($validated['image']));
            }
            return response()->json([
                'status' => 'error',
                'message' => 'مشکلی پیش آمد. لطفا بعدا دوباره تلاش کنید.'
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        DB::beginTransaction();
        try {
            $banner->delete();
            DB::commit();
            
            // حالا فایل را حذف می‌کنیم
            if (Storage::disk('public')->exists($banner->image)) {
                if (!Storage::disk('public')->delete($banner->image)) {
                    Log::error("فایل بنر {$banner->image} حذف نشد!");
                }
            }
            return response()->json(['status'=>'success','message'=>'این بنر با موفقیت حذف شد']);
        
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>'مشکلی پیش آمد. لطفا بعد از مدتی دوباره تلاش کنید.']);

        }
    }

    public function toggle(Banner $banner)
    {
        $banner->status = $banner->status === 'active' ? 'inactive' : 'active';
        $banner->save();

        return response()->json(['status' => $banner->status]);
    }


}
