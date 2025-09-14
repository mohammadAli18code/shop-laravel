<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Cart;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $parent_cats = Category::with('children')->whereNull('parent_id') ->get();
        // $children_cats = Category::with('children')->whereNotNull('parent_id') ->get();
        $banners = Banner::all();
        $products = Product::approved()->take(10)->get();
        $cart = Cart::all();
        $favorite_products = Product::approved()->take(10)->get();
        $newest_products = Product::approved()->take(10)->get();
        // dd($children_cats);
        return view('app.index' , compact([
            'banners' ,
            'products',
            'cart',
            'favorite_products',
            'newest_products',
        ])
    );
    }

    public function welcome(){
        return view('app.welcome');
    }

}
