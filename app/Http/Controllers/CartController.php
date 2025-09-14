<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product.discounts')->first();
        $cartItems = $cart->items;
        if(!$cartItems)
        {
            //route ? or no ?
            return view('app.cart.cartEmpty');
        }
        
        return view('app.cart.index' , compact('cartItems' , 'cart'));
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
    public function store(StoreCartRequest $request)
    {
        $user = auth()->user();
        $product = Product::find($request->input('product_id'));

        $cart = Cart::where('user_id', $user->id)
                        ->where('status' , 'active')
                        ->first();

        if (!$cart){
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);
        }else{
            $cart->touch(); // update 'updated_at' in carts table
        }
        $cartItem = CartItem::where('cart_id' , $cart->id)->where('product_id' , $product->id)->first();
        if($cartItem){
            //update
            $cartItem->quantity += 1;
            $cartItem->price = $cartItem->quantity * $product->price;
            $cartItem->save();
        }else{
            //insert
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);

        }
        //json
        return response()->json([
            'success' => true,
            'quantity' => $cartItem->quantity,
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        // dd('hiiii');
        $cart->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
